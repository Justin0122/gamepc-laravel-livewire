<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-40">
        @php $fields = ['cpu', 'gpu', 'case_cooler', 'pc_case', 'motherboard', 'psu', 'ram', 'storage', 'cpu_cooler']; $count = 0@endphp
    @foreach($randomProducts as $part)
                    <x-card
                        :title="Str::limit($part->Name, 20) . ''"
                        :title-classes="'text-2xl mb-3'"
                        :description="Str::limit($part->description, 100) . ''"
                        :image="$part->image ?? 'https://placehold.co/1200x1200'"
                        :button="['url' => '/part/' . $fields[$count] . '?id=' . $part->id, 'label' => 'View']"
                    />
        @php $count++ @endphp
        @endforeach
    </div>
</div>

