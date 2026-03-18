{{--
Component to display uploaded documents/files

This component evaluates the number of uploaded documents and
presents an appropriate message. It enumerates each document
with its filename and the date it was uploaded.
--}}
@props(['uploadedDocuments'])
<div>
    @if (count($uploadedDocuments) > 1)
        <p class="copy-bold line-height-100">Folgende Dokumente wurden hochgeladen:</p>
    @else
        <p class="copy-bold line-height-100">Folgendes Dokument wurde hochgeladen:</p>
    @endif
    @foreach ($uploadedDocuments as $document)
        <div class="x-document-upload">
            <p class="copy">{{ $document['dateiname'] ?? "Dateiname" }}</p>
            <span class="copy no-wrap">vom: {{ $document['hochgeladen_am'] ?? "dd.mm.yyyy" }}</span>
        </div>
    @endforeach
</div>