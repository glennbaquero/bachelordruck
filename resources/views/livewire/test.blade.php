<div>
{{--    <form wire:submit.prevent="update">--}}
{{--        <x-input.select--}}
{{--            wire:model.lazy="test"--}}
{{--            label="Test"--}}
{{--            :options="Domain\Teams\Models\Team::select(['name', 'id'])->get()->toArray()"--}}
{{--            option-label="name"--}}
{{--            option-value="id"--}}
{{--            :value="$test"--}}
{{--            :avatar="true"--}}
{{--        >--}}
{{--        </x-input.select>--}}
{{--        <button type="submit"> Submit</button>--}}
{{--    </form>--}}
{{--    <ul wire:sortable-group="update">--}}
{{--        <li wire:sortable.item="1" wire:key="1"><span wire:sortable.handle>*</span>Test1</li>--}}
{{--        <ul wire:wire:sortable-group.item-group="g1">--}}
{{--            <li wire:sortable-group.item="11" wire:key="11"><span wire:sortable.handle>**</span>Test11</li>--}}
{{--            <li wire:sortable-group.item="12" wire:key="12"><span wire:sortable.handle>**</span>Test12</li>--}}
{{--        </ul>--}}
{{--        <li wire:sortable.item="2" wire:key="2"><span wire:sortable.handle>*</span>Test2</li>--}}
{{--        <ul wire:wire:sortable-group.item-group="g1">--}}
{{--            <li wire:sortable.item="21" wire:key="21"><span wire:sortable.handle>**</span>Test21</li>--}}
{{--            <ul wire:wire:sortable-group.item-group="g2">--}}
{{--                <li wire:sortable-group.item="31" wire:key="31"><span wire:sortable.handle>***</span>Test31</li>--}}
{{--                <li wire:sortable-group.item="32" wire:key="32"><span wire:sortable.handle>***</span>Test32</li>--}}
{{--            </ul>--}}
{{--            <li wire:sortable.item="22" wire:key="22"><span wire:sortable.handle>**</span>Test22</li>--}}
{{--        </ul>--}}
{{--    </ul>--}}


    <ul wire:sortable-group="updateGroup">
        <li wire:sortable.item="g1" wire:key="1"><span wire:sortable.handle>*</span>Group 1</li>
        <ul wire:wire:sortable-group.item-group="g1">
            <li wire:sortable-group.item="11" wire:key="11"><span wire:sortable.handle>**</span>Test11</li>
            <li wire:sortable-group.item="12" wire:key="12"><span wire:sortable.handle>**</span>Test12</li>
        </ul>
        <li wire:sortable.item="g2" wire:key="2"><span wire:sortable.handle>*</span>Group 2</li>
        <ul wire:wire:sortable-group.item-group="g2">
            <li wire:sortable-group.item="21" wire:key="21"><span wire:sortable.handle>**</span>Test21</li>
            <li wire:sortable-group.item="22" wire:key="22"><span wire:sortable.handle>**</span>Test22</li>
        </ul>
    </ul>

    <div wire:sortable-group="updateGroup" style="display: flex">
        <div wire:sortable.item="1" wire:key="group-1">
            <h4>Group1</h4>

            <ul wire:sortable-group.item-group="1">
                <li wire:sortable-group.item="11" wire:key="task-11">
                    <span>Test1</span>
                    <button wire:sortable.handle>drag</button>
                </li>
                <li wire:sortable-group.item="12" wire:key="task-12">
                    <span>Test2</span>
                    <button wire:sortable.handle>drag</button>
                </li>
            </ul>
        </div>
        <div wire:sortable.item="2" wire:key="group-2">
            <h4>Group1</h4>

            <ul wire:sortable-group.item-group="2">
                <li wire:sortable-group.item="21" wire:key="task-21">
                    <span>Test3</span>
                    <button wire:sortable.handle>drag</button>
                </li>
                <li wire:sortable-group.item="22" wire:key="task-22">
                    <span>Test4</span>
                    <button wire:sortable.handle>drag</button>
                </li>
            </ul>
        </div>
    </div>

    @foreach ($categories as $category)
        <x-tree.root :root="$category"/>
    @endforeach
</div>








