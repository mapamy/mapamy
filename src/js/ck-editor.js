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
            'imageUpload',
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
    extraPlugins: [MyCustomUploadAdapterPlugin],
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
        resizeUnit: 'px',
        upload: {
            types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'heic', 'heif'],
        }
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

// Custom Upload Adapter Plugin
function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        // Pass mapId to the upload adapter
        return new MyUploadAdapter(loader, editor.config.get('mapId'));
    };
}

class MyUploadAdapter {
    constructor(loader, mapId) {
        this.loader = loader;
        this.mapId = mapId;
    }

    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                })
        );
    }

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = (this.xhr = new XMLHttpRequest());
        xhr.open('POST', `/upload-editor-image/${this.mapId}`, true);
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (!response || response.error) {
                return reject(response && response.error ? response.error : genericErrorText);
            }

            // Update the button's data attributes and div visibility
            const setCoordinatesButton = document.getElementById('set-image-autodetected-coordinates');
            const gpsDiv = document.querySelector('.image-autodetected-cooridnates');

            if (setCoordinatesButton && gpsDiv) {
                if (response.gps) {
                    // GPS data is available
                    setCoordinatesButton.dataset.latitude = response.gps.latitude;
                    setCoordinatesButton.dataset.longitude = response.gps.longitude;
                    // Show the div containing the button
                    gpsDiv.style.display = 'block';
                } else {
                    // No GPS data available
                    setCoordinatesButton.dataset.latitude = '';
                    setCoordinatesButton.dataset.longitude = '';
                    // Hide the div containing the button
                    gpsDiv.style.display = 'none';
                }
            }

            resolve({
                default: response.url,
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', (evt) => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);

        this.xhr.send(data);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const wysiwygElement = document.querySelector('#wysiwyg');
    const mapId = wysiwygElement.getAttribute('data-map-id');

    // Make sure wysiwyg and mapId are set
    if (!wysiwygElement || !mapId) {
        return;
    }

    // Set mapId in the config
    editorConfig.mapId = mapId;

    ClassicEditor.create(wysiwygElement, editorConfig).catch((error) => {
        console.error(error);
    });
});