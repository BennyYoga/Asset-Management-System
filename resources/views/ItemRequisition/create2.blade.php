@extends('Template.template')

@section('title','Asset Monitoring System | Create Item')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('content')
<div class="container">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Drag and Drop File Upload Using Dropzone JS in Laravel 8 - Techsolutionstuff</h1><br>
            <div class="wrapper">

                <section class="container-fluid inner-page">

                    <div class="row">

                        <div class="col-xl-6 offset-xl-3 col-lg-6 offset-lg-3 col-md-12 full-dark-bg">

                            <!-- Files section -->
                            <h4 class="section-sub-title"><span>Upload</span> Your Files</h4>

                            <form action="{{route('dropzone.store')}}" class="dropzone files-container">
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>

                            <!-- Notes -->
                            <span>Only JPG, PNG, PDF, DOC (Word), XLS (Excel), PPT, ODT and RTF files types are supported.</span>
                            <span>Maximum file size is 25MB.</span>

                            <!-- Uploaded files section -->
                            <h4 class="section-sub-title"><span>Uploaded</span> Files (<span class="uploaded-files-count">0</span>)</h4>
                            <span class="no-files-uploaded">No files uploaded yet.</span>

                            <!-- Preview collection of uploaded documents -->
                            <div class="preview-container dz-preview uploaded-files">
                                <div id="previews">
                                    <div id="onyx-dropzone-template">
                                        <div class="onyx-dropzone-info">
                                            <div class="thumb-container">
                                                <img data-dz-thumbnail />
                                            </div>
                                            <div class="details">
                                                <div>
                                                    <span data-dz-name></span> <span data-dz-size></span>
                                                </div>
                                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                <div class="actions">
                                                    <a href="#!" data-dz-remove><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Warnings -->
                            <div id="warnings">
                                <span>Warnings will go here!</span>
                            </div>

                        </div>
                    </div><!-- /End row -->

                </section>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('sweetalert::alert')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
!(function ($) {
    'use strict';

    // Global Onyx object
    var Onyx = Onyx || {};

    Onyx = {
        /**
         * Fire all functions
         */
        init: function () {
            var self = this,
                obj;

            for (obj in self) {
                if (self.hasOwnProperty(obj)) {
                    var _method = self[obj];
                    if (_method.selector !== undefined && _method.init !== undefined) {
                        if ($(_method.selector).length > 0) {
                            _method.init();
                        }
                    }
                }
            }
        },

        /**
         * Files upload
         */
        userFilesDropzone: {
            selector: 'form.dropzone',
            init: function () {
                var base = this,
                    container = $(base.selector);

                base.initFileUploader(base, 'form.dropzone');
            },
            initFileUploader: function (base, target) {
                var previewNode = document.querySelector('#onyx-dropzone-template'), // Dropzone template holder
                    warningsHolder = $('#warnings'); // Warning messages' holder

                previewNode.id = '';

                var previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                var onyxDropzone = new Dropzone(target, {
                    url: "{{route('dropzone.store')}}", // Check that our form has an action attr and if not, set one here
                    maxFiles: 5,
                    maxFilesize: 20,
                    acceptedFiles:
                        'image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf',
                    previewTemplate: previewTemplate,
                    previewsContainer: '#previews',
                    clickable: true,

                    createImageThumbnails: true,
                    dictFileSizeUnits: { tb: 'TB', gb: 'GB', mb: 'MB', kb: 'KB', b: 'b' }
                });

                Dropzone.autoDiscover = false;

                onyxDropzone.on('addedfile', function (file) {
                    $('.preview-container').css('visibility', 'visible');
                    file.previewElement.classList.add('type-' + base.fileType(file.name)); // Add type class for this element's preview
                });

                onyxDropzone.on('totaluploadprogress', function (progress) {
                    var progr = document.querySelector('.progress .determinate');

                    if (progr === undefined || progr === null) return;

                    progr.style.width = progress + '%';
                });

                onyxDropzone.on('dragenter', function () {
                    $(target).addClass('hover');
                });

                onyxDropzone.on('dragleave', function () {
                    $(target).removeClass('hover');
                });

                onyxDropzone.on('drop', function () {
                    $(target).removeClass('hover');
                });

                onyxDropzone.on('addedfile', function () {
                    // Remove no files notice
                    $('.no-files-uploaded').slideUp('easeInExpo');
                });

                onyxDropzone.on('removedfile', function (file) {
                    $.ajax({
                        type: 'POST',
                        url: "{{route('dropzone.store')}}",
                        data: {
                            target_file: file.upload_ticket,
                            delete_file: 1
                        }
                    });

                    // Show no files notice
                    if (base.dropzoneCount() == 0) {
                        $('.no-files-uploaded').slideDown('easeInExpo');
                        $('.uploaded-files-count').html(base.dropzoneCount());
                    }
                });

                onyxDropzone.on('success', function (file, response) {
                    let parsedResponse = JSON.parse(response);
                    file.upload_ticket = parsedResponse.file_link;

                    // Make it wait a little bit to take the new element
                    setTimeout(function () {
                        $('.uploaded-files-count').html(base.dropzoneCount());
                        console.log('Files count: ' + base.dropzoneCount());
                    }, 350);

                    // Something to happen when file is uploaded, like showing a message
                    if (typeof parsedResponse.info !== 'undefined') {
                        console.log(parsedResponse.info);
                        warningsHolder.children('span').html(parsedResponse.info);
                        warningsHolder.slideDown('easeInExpo');
                    }
                });
            },
            dropzoneCount: function () {
                var filesCount = $('#previews > .dz-success.dz-complete').length;
                return filesCount;
            },
            fileType: function (fileName) {
                var fileType = /[.]/.exec(fileName) ? /[^.]+$/.exec(fileName) : undefined;
                return fileType[0];
            }
        }
    };

    $(document).ready(function () {
        Onyx.init();
    });
})(jQuery);
</script>
@endpush