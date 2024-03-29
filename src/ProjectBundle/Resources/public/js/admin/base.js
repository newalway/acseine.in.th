$(document).ready(function(){

    // $('#start_date').datepicker({
    //   format: 'dd/mm/yyyy'
    // });

    $(".fancybox").fancybox();

    $('#form_submit_button').on('click', function(){
        var form_id =  $(this).data('form_id');
        var frm = $('#'+form_id);
        frm.submit();
    });

    $('#group_delete').on('click', function(){
        if(confirm('Are you sure you want to delete?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('delete_path'));
            frm.submit();
        }
    });

    $('#group_enable_confirm').on('click',function(){
        if(confirm('Are you sure you want to enable?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('enable_path'));
            frm.submit();
        }
    });

    $('#group_enable').on('click',function(){
        var form_id =  $(this).data('form_id');
        var frm = $('#'+form_id);
        frm.attr('action', frm.data('enable_path'));
        frm.submit();
    });

    $('#group_disable_confirm').on('click',function(){
        if(confirm('Are you sure you want to disable?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('disable_path'));
            frm.submit();
        }
    });

    $('#group_disable').on('click',function(){
        var form_id =  $(this).data('form_id');
        var frm = $('#'+form_id);
        frm.attr('action', frm.data('disable_path'));
        frm.submit();
    });

    $('#group_sendmail').on('click',function(){
        if(confirm('Are you sure you want to send the email?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('sendmail_path'));
            frm.submit();
        }
    });

    $('a.delete').on('click', function(){
        if(confirm('Are you sure you want to delete?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.append('<input type="hidden" value="DELETE" name="_method">');
            frm.attr('action', frm.data('delete_path'));
            frm.submit();
        }
    });

    $('#search_export_excel_path').on('click',function(){
        if(confirm('Are you sure you want to export?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('search_export_excel_path'));
            frm.submit();
        }
    });

    $('#search_export_excel_summary_report_path').on('click',function(){
        if(confirm('Are you sure you want to export?')){
            var form_id =  $(this).data('form_id');
            var frm = $('#'+form_id);
            frm.attr('action', frm.data('search_export_excel_summary_report_path'));
            frm.submit();
        }
    });

    $('#search_data_path').on('click',function(){
        var form_id =  $(this).data('form_id');
        var frm = $('#'+form_id);
        frm.attr('action', frm.data('search_data_path'));
        frm.submit();
    });

    //iCheck for checkbox and radio inputs
    // $('input[type="checkbox"], input[type="radio"]').iCheck({
    //   checkboxClass: 'icheckbox_square-blue',
    //   radioClass: 'iradio_square-blue'
    // });

    $('.icheck input[type="checkbox"], .icheck input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

    var checkAll = $('input#select_all');
    var checkboxes = $('input.check_all');
    checkAll.on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

    $( ".removePhotoGalleryData" ).click(function(e) {
        e.preventDefault();
		var link = $(this),
    		image_id = link.data('id'),
    		remove_elem_name = link.data('remove_elem_name'),
    		data_gallery_remove_elem = document.getElementById(remove_elem_name),
    		del_input_hidden = document.createElement("input"),
    		photo_gallery_elem  = link.closest(".photo-gallery");

		del_input_hidden.setAttribute("type", "hidden");
		del_input_hidden.setAttribute("name", "del_img_gallery[]");
		del_input_hidden.setAttribute("value", image_id);
		data_gallery_remove_elem.appendChild(del_input_hidden);
		photo_gallery_elem.remove();
	});
});

function pad2(number) {
    return (number < 10 ? '0' : '') + number
}

function initAjaxSortableSaveData()
{
    $("#save_sortdata").click(function(e){
        e.preventDefault();

        var sorted = $("#sortable").sortable("serialize");
        var save_btn = $(this);
        var loader_icon = $('#loader');
        var flash_notice = $('.flash-notice');
        var uri = save_btn.data("uri");

        $.ajax({
            data: sorted,
            type: 'POST',
            url: uri,
            beforeSend: function() {
                save_btn.prop('disabled', true);
                loader_icon.show();
                flash_notice.html('');
            },
            complete: function (jqXHR, status) {
                save_btn.prop('disabled', false);
                loader_icon.hide();
            },
            success: function (data) {
                if (data == 'complete') {
                    flash_notice.empty().html(' <div class="alert alert-success alert-dismissable"> <i class="fa fa-check"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button>Saved successfully</div> ');
                    setTimeout(function() {
                        flash_notice.html('');
                    }, 5000);
                }
            },
            error: function (jqXHR, status, err) {
                flash_notice.empty().html(' <div class="alert alert-warning alert-dismissable"> <i class="fa fa-warning"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &times; </button>Error </div> ');
            }
        });
    });
}

function initJueryThailand(db, frm_id, dst_id, amp_id, pro_id, zip_id)
{
    var data_form = $('#'+frm_id),
    obj_district = data_form.find("#"+dst_id),
    obj_amphoe = data_form.find("#"+amp_id),
    obj_province = data_form.find("#"+pro_id),
    obj_zipcode = data_form.find("#"+zip_id);

    $.Thailand({
        database: db,
        $district: obj_district,
        $amphoe: obj_amphoe,
        $province: obj_province,
        $zipcode: obj_zipcode,

        onDataFill: function(data){
            // console.info('Data Filled', data);
        },
        onLoad: function(){
            // console.info('Autocomplete is ready!');
            // $('#loader').toggle();
        }
    });

    obj_district.change(function(){
        // console.log('district', this.value);
    });
    obj_amphoe.change(function(){
        // console.log('amphoe', this.value);
    });
    obj_province.change(function(){
        // console.log('province', this.value);
    });
    obj_zipcode.change(function(){
        // console.log('zipcode', this.value);
    });
}

//Google geocoded location
function initGeocodeMap()
{
    var objLatLng = getElementLatLng(),
    mapLatLng = new google.maps.LatLng( objLatLng.lat, objLatLng.lng ),
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 14,
        center: mapLatLng
    }),
    geocoder = new google.maps.Geocoder(),
    marker = new google.maps.Marker({
        map: map,
        position: mapLatLng,
        draggable: true
    });

    var infowindow = new google.maps.InfoWindow;

    //show formated address when start
    //geocodeFormattedAddress(geocoder, map, marker, infowindow);

    //Event listenner click search
    document.getElementById('submit-map').addEventListener('click', function() {
        geocodeSearchAddress(geocoder, map, marker, infowindow);
    });

    //Event listenner draged marker
    google.maps.event.addListener(marker, 'dragend', function (event) {
        //set input value
        setElementLatLng(this.getPosition().lat(), this.getPosition().lng());

        //set formated address
        geocodeFormattedAddress(geocoder, map, marker, infowindow);
    });

    //Event listenner change lat, lng
    document.getElementById('latitude').addEventListener('change', function() {
        geocodeSetPositonFromLatLng(geocoder, map, marker, infowindow);
    });
    document.getElementById('longitude').addEventListener('change', function() {
        geocodeSetPositonFromLatLng(geocoder, map, marker, infowindow);
    });
}

function geocodeSearchAddress(geocoder, resultsMap, marker, infowindow) {
    var address = $('#geocode-address').val();
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            //move to
            resultsMap.setCenter(results[0].geometry.location);
            //set marker
            marker.setPosition(results[0].geometry.location);
            //set input value
            setElementLatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

            //set place_id
            setElementPlaceId(results[0].place_id);

            //set formated address
            infowindow.setContent(results[0].formatted_address);
            infowindow.open(resultsMap, marker);

        } else {
            alert('Search geocode was not successful for the following reason: ' + status);
        }
    });
}

function geocodeFormattedAddress(geocoder, resultsMap, marker, infowindow) {
    var pos = marker.getPosition();
    geocoder.geocode({
        latLng: pos
    }, function(responses) {
        if (responses && responses.length > 0) {
            //set formated address
            infowindow.setContent(responses[0].formatted_address);
            infowindow.open(resultsMap, marker);

            //set place_id
            setElementPlaceId(responses[0].place_id);

            return place_id;
        } else {
            //Cannot determine address at this location.
            infowindow.setContent('');
            infowindow.close();
        }
    });
}

function geocodeSetPositonFromLatLng(geocoder, resultsMap, marker, infowindow)
{
    var localObjLatLng = getElementLatLng();
    var localMapLatLng = new google.maps.LatLng( localObjLatLng.lat, localObjLatLng.lng );
    resultsMap.setCenter(localMapLatLng);
    //set marker
    marker.setPosition(localMapLatLng);
    //set formated address
    geocodeFormattedAddress(geocoder, resultsMap, marker, infowindow);
}

function setElementPlaceId(place_id)
{
    $('#placeId').val(place_id);
}
function setElementLatLng(lat,lng)
{
    $('#latitude').val(lat);
    $('#longitude').val(lng);
}
function getElementLatLng()
{
    //Default is Bangkok
    var lat = $('#latitude').val() || 13.756330900000009,
    lng = $('#longitude').val() || 100.50176510000006;
    return {"lat":lat, 'lng':lng};
}

//Photo Gallery
function BrowseServerGallery(galleryCanvas)
{
    CKFinder.popup( {
        width: 800,
        height: 600,
        chooseFiles: true,
        chooseFilesClosePopup: true,
        rememberLastFolder: true,
        startupFolderExpanded: true,
        resizeImages: 'small',
        onInit: function( finder ) {

            //listen to event
            finder.on( 'files:choose', function( evt ) {
                var gallery_canvas_elem = document.getElementById(galleryCanvas);

                evt.data.files.forEach( function( file ) {
                    // start append image to gallery
                    var fileUrl = file.getUrl();
                    fileThumbUrl = finder.request( 'file:getThumb', { file: file } ),
                    div_image_elem = document.createElement("div"),
                    img_elem = document.createElement("img"),
                    del_link = document.createElement("a"),
                    input_hidden = document.createElement("input");
                    div_image_elem.className = "photo-gallery img-responsive";
                    img_elem.src = fileThumbUrl;
                    img_elem.className = "img-responsive";
                    img_elem.setAttribute('data-fancybox', 'images');
                    img_elem.setAttribute('data-src', fileUrl);
                    img_elem.setAttribute('data-data-fancybox', 'group');
                    div_image_elem.appendChild(img_elem);

                    del_link.appendChild(document.createTextNode(" "));
                    del_link.setAttribute('href', '#');
                    //del_link.setAttribute('data-filename', fileUrl);
                    del_link.addEventListener('click', removeTempImage, false);
                    div_image_elem.appendChild(del_link);

                    input_hidden.setAttribute("type", "hidden");
                    input_hidden.setAttribute("name", "img_path[]");
                    input_hidden.setAttribute("value", fileUrl);
                    div_image_elem.appendChild(input_hidden);

                    gallery_canvas_elem.appendChild(div_image_elem);
                    // end append image to gallery
                } );
            } );

            finder.on( 'file:choose:resizedImage', function( evt ) {
                // not used
                // var output = document.getElementById( elementId );
                // output.value = evt.data.resizedUrl;
            } );

        }
    } );
}

function removeTempImage(e)
{
    e.preventDefault();
    var link = this,
    //remove_filename = link.getAttribute('data-filename'),
    photo_gallery_elem  = $(e.target).closest(".photo-gallery");
    photo_gallery_elem.remove();
    return false;
}

function setGroupCheckAll(id_checkall, class_item){
    // class_checkall = "showroom_select_all";
    // class_item = "showroom_check_item";
    var checkAll = $('input#'+id_checkall);
    var checkboxes = $('input.'+class_item);
    checkAll.on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });
}

// CKFinderClass https://docs-old.ckeditor.com/ckfinder3/?mobile=/api/CKFinder.Application#event-files_choose
