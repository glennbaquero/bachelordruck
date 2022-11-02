# https://mattstauffer.com/blog/how-to-set-up-your-laravel-application-for-zero-downtime-envoyer-capistrano-deploys/

# Update the current branch
git pull origin $REPO_BRANCH

# Load variables from .env file
set -o allexport
source .env
set +o allexport

# Get the current version from the app config
VERSION=$(cat config/app.php \
| grep version \
| head -1 \
| awk -F "=>" '{ print $2 }' \
| sed "s/[',]//g" \
| tr -d '[[:space:]]'
)

# If version already exists, it will not deploy
if [[ -d "releases/$VERSION" ]]; then
    echo "Release $VERSION already exists."
    exit 1
fi

# REPO_URL must be defined in the .env file
# Clone the repository to a new folder under releases
git clone -b $REPO_BRANCH $REPO_URL releases/$VERSION
if [ $? -ne 0 ]; then
    echo "Unable to clone repository."
    exit 1
fi

# Go to the current version folder
cd releases/$VERSION

# Remove the symlink for .env file and storage folder
rm -f .env && ln -s ../../.env .env
rm -rf storage && ln -s ../../storage storage

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan livewire:discover

# Migrate the database migrations
php artisan migrate --force

# Remove the symlink and create a new symlink to the new version folder
cd ../../
rm -Rf current && ln -s releases/$VERSION/ current

# Go to the current version folder
cd releases/$VERSION

# Run the database migration
php artisan db:seed --force

# Restart fpm, not using fpm
# echo "" | sudo -S systemctl restart php8.1-fpm

php artisan queue:restart
php artisan storage:link
php artisan releases:keep ..

# Create a tag
git tag -a v$VERSION -m "Release version $VERSION"
git push origin v$VERSION

echo "Successfully released version: $VERSION."
