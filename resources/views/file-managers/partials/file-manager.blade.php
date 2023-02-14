<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#333844">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#333844">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#333844">

  <title>{{ trans('laravel-filemanager::lfm.title-page') }}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/72px color.png') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/cropper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/dropzone.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/mime-icons.min.css') }}">
  <style>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/css/lfm.css')) !!}</style>
  {{-- Use the line below instead of the above if you need to cache the css. --}}
  {{-- <link rel="stylesheet" href="{{ asset('/vendor/laravel-filemanager/css/lfm.css') }}"> --}}
</head>
<body>
  <nav class="bg-light fixed-bottom border-top d-none" id="actions">
    <a data-action="open" data-multiple="false"><i class="fas fa-folder-open"></i>{{ trans('laravel-filemanager::lfm.btn-open') }}</a>
    <a data-action="preview" data-multiple="true"><i class="fas fa-images"></i>{{ trans('laravel-filemanager::lfm.menu-view') }}</a>
    <a data-action="use" data-multiple="true"><i class="fas fa-check"></i>{{ trans('laravel-filemanager::lfm.btn-confirm') }}</a>
  </nav>
    <!-- <div class="file-manager"></div> -->
    <div class="d-flex flex-row">
    <div id="tree"></div>

    <div id="main">
      <div id="alerts"></div>

      <nav aria-label="breadcrumb" class="d-none d-lg-block" id="breadcrumbs">
        <ol class="breadcrumb">
          <li id="breadcrumb-item" class="breadcrumb-item">Home</li>
        </ol>
      </nav>

      <div id="empty" class="d-none">
        <i class="far fa-folder-open"></i>
        {{ trans('laravel-filemanager::lfm.message-empty') }}
      </div>

      <div id="content"></div>
      <div id="pagination"></div>

      <a id="item-template" class="d-none">
        <div class="square"></div>

        <div class="info">
          <div class="item_name text-truncate"></div>
          <time class="text-muted font-weight-light text-truncate"></time>
        </div>
      </a>
    </div>

    <div id="fab"></div>
  </div>

  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">{{ trans('laravel-filemanager::lfm.title-upload') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aia-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('unisharp.lfm.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data' class="dropzone">
            <div class="form-group" id="attachment">
              <div class="controls text-center">
                <div class="input-group w-100">
                  <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('laravel-filemanager::lfm.message-choose') }}</a>
                </div>
              </div>
            </div>
            <input type='hidden' name='working_dir' id='working_dir'>
            <input type='hidden' name='type' id='type' value='{{ request("type") }}'>
            <input type='hidden' name='_token' value='{{csrf_token()}}'>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="notify" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
          <button type="button" class="btn btn-primary w-100" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
          <button type="button" class="btn btn-primary w-100" data-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
        </div>
      </div>
    </div>
  </div>

  <div id="carouselTemplate" class="d-none carousel slide bg-light" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#previewCarousel" data-slide-to="0" class="active"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a class="carousel-label"></a>
        <div class="carousel-image"></div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#previewCarousel" role="button" data-slide="prev">
      <div class="carousel-control-background" aria-hidden="true">
        <i class="fas fa-chevron-left"></i>
      </div>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#previewCarousel" role="button" data-slide="next">
      <div class="carousel-control-background" aria-hidden="true">
        <i class="fas fa-chevron-right"></i>
      </div>
      <span class="sr-only">Next</span>
    </a>
  </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/cropper.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/laravel-filemanager/js/script.js') }}"></script> --}}
<script>
    var root_folders = {!! json_encode($root_folders) !!};
    var breadCrumb = document.getElementById('breadcrumb');
    var liBreadcrumb = document.getElementById('breadcrumb-item');

    var decorateValueBreadcrumb = function (string) {
        var arr = string.split('/');
        var result = '';
        for (let i = 0; i < arr.length; i++) {
            result += `<a href="#" data-path="${arr[i]}">${
                arr[i].charAt(0).toUpperCase() + arr[i].slice(1)
            }</a>/`;
        }
        return result;
    };

    var transferValueToBreadcrubWhenClickOnTree = function (e) {
        var target = e.target;
        if (target.tagName == 'A') {
            var path = target.getAttribute('data-path');
            liBreadcrumb.setAttribute('data-path', decorateValueBreadcrumb(path));
            liBreadcrumb.innerHTML = decorateValueBreadcrumb(path);
        }
    };

    var createULandLI = function (root_folders) {
        var ul = document.createElement('ul');
        ul.className = 'nav nav-pills flex-column';
        for (let i = 0; i < root_folders.length; i++) {
            let li = document.createElement('li');
            li.className = 'nav-item';
            var a = document.createElement('a');
            a.className = 'nav-link';
            if (root_folders[i].type == 'folder') {
                a.setAttribute('data-toggle', 'collapse');
                a.setAttribute('data-target', '#collapse' + i);
                a.setAttribute('data-path', root_folders[i].url);
                a.setAttribute('aria-expanded', 'false');
                a.setAttribute('aria-controls', 'collapse' + i);
                a.href = '#';
                let il = document.createElement('i');
                il.className = 'fa fa-folder fa-fw';
                a.appendChild(il);
                a.appendChild(document.createTextNode(root_folders[i].name));
                li.appendChild(a);
                let sub_ul = createULandLI(root_folders[i].items);
                sub_ul.id = 'collapse' + i;
                sub_ul.className = 'collapse';
                li.appendChild(sub_ul);
                ul.appendChild(li);
                continue;
            } else {
                a.className = 'nav-link';
                a.href = '#';
            }
            a.setAttribute('data-type', 0);
            a.setAttribute('data-path', root_folders[i].url);
            let il = document.createElement('i');
            if (root_folders[i].type == 'folder') {
                il.className = 'fa fa-folder fa-fw';
            } else {
                il.className = 'fa fa-file fa-fw';
            }
            a.appendChild(il);
            a.appendChild(document.createTextNode(root_folders[i].name));
            li.appendChild(a);
            ul.appendChild(li);
            if (root_folders[i].items && root_folders[i].items.length > 0) {
                let sub_ul = createULandLI(root_folders[i].items);
                li.appendChild(sub_ul);
            }
        }
        return ul;
    };
    var ul = createULandLI(root_folders);
    var file_manager = document.querySelector('#tree');
    file_manager.appendChild(ul);

    var tree = document.querySelector('#tree');
    tree.addEventListener('click', transferValueToBreadcrubWhenClickOnTree);
    // tree.addEventListener('click', )
    tree.addEventListener('click', function (e) {
        var target = e.target;
        if (target.tagName == 'A') {
            var path = target.getAttribute('data-path');
            var type = target.getAttribute('data-type');
            if (type == 0) {
                var url = '/manage-files/get-files?path=' + path;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        var files = data
                        console.log(data);
                        var html = '';
                        for (let i = 0; i < files.length; i++) {
                            html += `
                            <div class="col-sm-2">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="${files[i].url}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>`;
                        }
                        $('#content').html(html);
                    },
                });
            }
        }
    });

</script>
