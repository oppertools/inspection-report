@php
        $signaturesCount = $data->signaturesCount->signatures;
        $signatoriesCount = $data->signatories;
        $hasMissingSignature = $signaturesCount < $signatoriesCount;
@endphp
<div class="grid grid-cols-3 gap-10">
        @if($data->signatories)
                @foreach($data->signatories as $index => $signatory)
                @php
                        $signatureIndex = $hasMissingSignature ? $index : $index + 1;
                        $hasSignature = !($signaturesCount < $signatoriesCount && $index === 0);
                @endphp
                <x-signatory
                        :signatory="$signatory"
                        :type="$signatory->type"
                        :name="$signatory->fullName"
                        :index="$signatureIndex"
                        :hasSignature="$hasSignature"
                        :date="$data->formatedNumericFinalizedDate()"
                />
        @endforeach
        @endif
</div>
