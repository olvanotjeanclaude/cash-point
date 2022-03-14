import axios from "axios";

axios.get("/admin/notifications").then((result) => {
    const data = result.data;
    if (data.success) {
        //console.log("meeting");
        $("#alertToast #title").html(data.title);
        $("#alertToast .toast-body").html(data.message);
        $("#alertToast").toast("show");
        $("#alertToast2").toast("show");
    }
})