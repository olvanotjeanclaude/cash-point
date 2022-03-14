$(document).ready(function() {
    loadPage();
    init_plugin();
    //Count items in sidebar
    count_items();
    check_staff_usage_date();

    $(".list-container").on("click", ".remove-btn", delete_item);
    $(".card-body").on("click", ".remove", delete_item);


    $(".list-container").on("click", ".get-item-btn", show_item);
    $(".show-item-btn").on("click", show_item); //with modal
    $(".delete-item-btn").on("click", delete_item); //with modal

    $("#province").on("change", get_district_list);
    $("#district").on("change", get_neighborhood_list);

    if ($("table").length > 0) {
        //$("table").addClass("table-sm")
        $("table td").addClass("align-middle")
    }

    //setTimeout(() => , 300);
    $(".loading-table").addClass("d-none")
    $(".table-responsive").css("display", "block");
})


function delete_item() {
    let $data_url = $(this).data("url");
    let rowId = $(this).data("id");

    const rowItem = $(`#row_${rowId}`)
    const rowDetail = $(this).closest(".child");
    const parent = $(this).closest(".project-card");

    swal.fire({
        title: "Emin misiniz?",
        text: "Bu işlem için devam etmek ister misiniz?",
        icon: "warning",
        cancelButtonText: "Hayır",
        confirmButtonText: 'Evet',
        allowOutsideClick: false,
        showDenyButton: true,
        reverseButtons: true,
        confirmButtonColor: '#45cb85',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $data_url,
                method: 'DELETE',
                success: function(result) {
                    let type = (result.type == "success") ? "success" : "error";
                    const message = (type == "success") ? result.success : result.error;

                    if (type) {
                        swal.fire({
                            title: type,
                            text: message,
                            icon: type
                        })

                        if (type == "success") {
                            rowDetail.remove();
                            if (parent.length > 0) {
                                parent.remove();
                            }
                            rowItem.remove();
                        }
                    }
                },
                error: function(data) {
                    swal.fire({
                        title: "Error",
                        text: "Beklenmedik hata oluştu. Sonra tekrar deneyiniz.",
                        icon: "error"
                    })
                }
            })
        }
    });
}


function count_items() {
    let data = true

    setInterval(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/api/count-items',
                method: 'post',
                data: {
                    control: data
                },
                success: function(result) {
                    if (result) {
                        if (result.countManager) $('#countUser').html(result.countUser)
                        if (result.countManager) $('#countManager').html(result.countManager)
                        if (result.countStaff) $('#countStaff').html(result.countStaff)
                        if (result.countConsultant) $('#countConsultant').html(result.countConsultant)
                        if (result.countCustomer) $('#countCustomer').html(result.countCustomer)
                        if (result.countBranch) $('#countBranch').html(result.countBranch)
                        if (result.countMyBranch) $('#countMyBranch').html(result.countMyBranch)
                        if (result.countMyCustomer) $('#countMyCustomer').html(result.countMyCustomer)
                        if (result.countMeeting) $('#countMeeting').html(result.countMeeting)
                        if (result.countMyMeeting) $('#countMyMeeting').html(result.countMyMeeting)
                        if (result.countNextMeeting) $('#countNextMeeting').html(result.countNextMeeting)
                        if (result.countProject) $('#countProject').html(result.countProject)
                        if (result.countSale) $('#countSale').html(result.countSale)
                        if (result.countMyBids) $('#myBids').html(result.countMyBids)
                    }
                }
            })
        }, 1500) // 2.5 saniye --> 2500
}

function check_staff_usage_date() {
    const data = true
    const url = "/api/check-usage-date-for-staff";

    setInterval(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'post',
                data: {
                    control: data
                },
                success: function(result) {
                    if (result) {
                        return true;
                    }
                }
            })
        }, 1500) // 5dk--> 300 saniye --> 300 000
}

function show_item() {
    const data_url = $(this).data("url");
    const resultId = $(this).data("result");
    const modal = $(this).data("target");

    $(resultId).empty();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: data_url,
        method: 'get',
        success: function(html) {
            if (html) {
                $(resultId).html(html);
                if (modal) {
                    $(modal).modal("show");
                }
            }
        },
        error: function() {
            swal.fire({
                title: "Error",
                text: "Beklenmedik hata oluştu. Sonra tekrar deneyiniz.",
                icon: "error"
            })
        }
    })
}

function get_district_list() {
    const provinceKEY = $(this).val();
    const url = "/admin/get-district-list?province_key=" + provinceKEY;

    if (provinceKEY) {
        $.ajax({
            type: "GET",
            url: url,
            success: function(res) {
                if (res) {
                    $('#district').empty()
                    $('#district').append('<option disabled>İlçe Seçiniz</option>')
                    $.each(res, function(key, value) {
                        $('#district').append('<option value="' + key +
                            '">' + value + '</option>')
                    })
                } else {
                    $('#district').empty()
                }
            }
        })
    } else {
        $('#district').empty()
        $('#neighborhood').empty()
    }

}

function get_neighborhood_list() {
    const districtKEY = $(this).val()
    const url = `/admin/get-neighborhood-list?district_key=${districtKEY}`;

    if (districtKEY) {
        $.ajax({
            type: "GET",
            url: url,
            success: function(res) {
                if (res) {
                    $('#neighborhood').empty()
                    $('#neighborhood').append(
                        '<option disabled>Mahalle Seçiniz</option>')
                    $.each(res, function(key, value) {
                        $('#neighborhood').append('<option value="' + key +
                            '">' + value + '</option>')
                    })
                } else {
                    $('#neighborhood').empty()
                }
            }
        })
    } else {
        $('#neighborhood').empty()
    }

}

function init_plugin() {
    const plugins = {
        "select2": $(".select2").length > 0,
    };

    try {
        //Select2
        if (plugins["select2"]) {
            $(".select2").select2();
        }

    } catch (error) {

    }
    //console.log(plugins)
}

function loadStaffs() {
    const url = "/api/staffs";
    let data = {};
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'get',
        async: false,
        data: {
            control: data
        },
        success: function(result) {
            if (result) {
                data = result;
            }
        }
    })
    return data;
}

function loadPage() {
    $("#loading").fadeOut();
    $("#left-sidebar").removeClass("loading-sidebar");
    $("#left-sidebar .invisible").removeClass("invisible");
}