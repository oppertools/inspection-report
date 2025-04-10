@php
        $signatoriesCount = $data->signaturesCount()->signatories;
        $signaturesCount = $data->signaturesCount()->signatures;
@endphp
<div class="grid grid-cols-3 gap-10">
        @if($data->signatories)
                @foreach($data->signatories as $index => $signatory)
                @php
                        $signatureIndex = $index + 1;
                @endphp
                <x-signatory
                        :signatory="$signatory"
                        :type="$signatory->type"
                        :name="$signatory->fullName"
                        :index="$signatureIndex"
                        :date="$data->formatedNumericFinalizedDate()"
                />
        @endforeach
        @endif
</div>
