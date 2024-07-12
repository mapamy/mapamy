import {
    ClassicEditor,
    AccessibilityHelp,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    Essentials,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    HtmlEmbed,
    Italic,
    Link,
    List,
    Paragraph,
    RemoveFormat,
    SelectAll,
    ShowBlocks,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    SimpleUploadAdapter,
    Style,
    Underline,
    Undo,
    Image,
    ImageToolbar,
    ImageUpload,
    ImageCaption,
    ImageStyle,
    ImageResize
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';
import '../css/ck-editor-styles.css';

const editorConfig = {
    toolbar: {
        items: [
            'undo',
            'redo',
            '|',
            'sourceEditing',
            'showBlocks',
            '|',
            'heading',
            'style',
            '|',
            'imageUpload', // Add this line
            '|',
            'fontSize',
            'fontFamily',
            'fontColor',
            'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'link',
            'highlight',
            'blockQuote',
            '|',
            'bulletedList',
            'numberedList'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        AccessibilityHelp,
        AutoLink,
        Autosave,
        BlockQuote,
        Bold,
        Essentials,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        HtmlEmbed,
        Italic,
        Link,
        List,
        Paragraph,
        RemoveFormat,
        SelectAll,
        ShowBlocks,
        SourceEditing,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        SimpleUploadAdapter,
        Style,
        Underline,
        Undo,
        Image,
        ImageToolbar,
        ImageUpload,
        ImageCaption,
        ImageStyle,
        ImageResize
    ],
    simpleUpload: {
        uploadUrl: '', // This will be set dynamically
    },
    image: {
        toolbar: [
            'imageTextAlternative',
            'toggleImageCaption',
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            'resizeImage:original',
            'resizeImage:50',
            'resizeImage:75',
            'resizeImage:custom'
        ],
        resizeOptions: [
            {
                name: 'resizeImage:original',
                label: 'Original',
                value: null
            },
            {
                name: 'resizeImage:50',
                label: '50%',
                value: '50'
            },
            {
                name: 'resizeImage:75',
                label: '75%',
                value: '75'
            },
            {
                name: 'resizeImage:custom',
                label: 'Custom',
                value: 'custom'
            }
        ],
        resizeUnit: 'px' // Use 'px' for pixels instead of '%'
    },
    fontFamily: {
        supportAllValues: true
    },
    fontSize: {
        options: [10, 12, 14, 'default', 18, 20, 22],
        supportAllValues: true
    },
    heading: {
        options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true
            }
        ]
    },
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    menuBar: {
        isVisible: true
    },
    placeholder: 'Type or paste your content here!',
    style: {
        definitions: [
            {
                name: 'Title',
                element: 'h2',
                classes: ['document-title']
            },
            {
                name: 'Subtitle',
                element: 'h3',
                classes: ['document-subtitle']
            },
            {
                name: 'Info box',
                element: 'p',
                classes: ['info-box']
            }
        ]
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const wysiwygElement = document.querySelector('#wysiwyg');
    const mapId = wysiwygElement.getAttribute('data-map-id');

    editorConfig.simpleUpload.uploadUrl = `/upload-editor-image/${mapId}`;

    ClassicEditor.create(wysiwygElement, editorConfig)
        .catch(error => {
            console.error(error);
        });
});
