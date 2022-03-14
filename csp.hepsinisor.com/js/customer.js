$(document).ready(function() {
    $(".popover-customer").on("click", function() {
        const customerId = $(this).data("id");
        const popoverId = $(this).attr("id");

        axios.get(`/admin/customer/${customerId}/meetings`)
            .then(function(response) {
                WebuiPopovers.show(`#${popoverId}`, {
                    content: response.data,
                    title: "Son 10 Görüşmeleri",
                })
            })
            .catch(function(error) {
                console.log(error);
            })
    })

    $("#customerStatus").change(function() {
        const status = $(this).val();

        if (status == "0") {
            $(".motifs").prop("disabled", false);
        } else {
            $(".motifs").val("");
            $("#otherMotif").addClass("d-none");
            $(".motifs").prop("disabled", true);
        }
    })

    $(".motifs").change(function() {
        const motif = $(this).val();
        if (motif == "other") {
            $("#otherMotif").removeClass("d-none");
        } else {
            $("#otherMotif").addClass("d-none");
        }
    })
})