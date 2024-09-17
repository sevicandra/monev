@props(['id', 'name', 'value' => '', 'acceptFiles' => true])

<div
    class="w-full bg-white border border-gray-300 relative border-gray-300 px-2 focus-within:ring-1 focus-within:border-indigo-500 focus-within:ring-indigo-500 rounded-md shadow-sm [&_trix-toolbar]:sticky [&_trix-toolbar]:top-0 [&_trix-toolbar]:-mx-2 [&_trix-toolbar]:px-2 [&_trix-toolbar]:bg-white [&_trix-toolbar]:border-b [&_trix-toolbar]:rounded-t-lg [&_trix-toolbar]:shadow-sm [&_trix-toolbar]:pt-2 [&_trix-toolbar]:z-10">
    <input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{{ $value }}" />

    <trix-editor
        {{ $attributes->merge(
            array_filter([
                'id' => $id,
                'class' => 'trix-content w-full ring-0 outline-none border-0 px-1 py-2 !shadow-none',
                'input' => "{$id}_input",
                'data-controller' => 'rich-text rich-text-uploader rich-text-mentions',
                'data-rich-text-uploader-accept-files-value' => $acceptFiles ? 'true' : 'false',
                'data-action' =>
                    'tribute-replaced->rich-text-mentions#addMention trix-attachment-remove->rich-text-uploader#removeAttachment trix-attachment-add->rich-text-uploader#addAttachment keydown->rich-text-uploader#handleKeyboardSubmit',
            ]),
        ) }}></trix-editor>
</div>
