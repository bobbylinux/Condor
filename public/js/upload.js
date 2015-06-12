(function () {
    var input = document.getElementById("images"),
            formdata = false;

    function showUploadedItem(source) {
        var list = document.getElementById("image-list"),
                li = document.createElement("li"),
                img = document.createElement("img");
        img.src = source;
        li.appendChild(img);
        list.appendChild(li);
    }

    if (window.FormData) {
        formdata = new FormData();
        document.getElementById("btn").style.display = "none";
    }

    input.addEventListener("change", function (evt) {
        document.getElementById("response").innerHTML = "Uploading . . ."
        var i = 0, len = this.files.length, img, reader, file;

        for (; i < len; i++) {
            file = this.files[i];

            if (!!file.type.match(/image.*/)) {
                if (window.FileReader) {
                    reader = new FileReader();
                    reader.onloadend = function (e) {
                        showUploadedItem(e.target.result, file.fileName);
                    };
                    reader.readAsDataURL(file);
                }
                if (formdata) {
                    formdata.append("images[]", file);
                }
            }
        }

        if (formdata) {
            var data = new FormData();
            $.each(formdata, function (key, value)
            {
                data.append(key, value);
            });

            $.ajax({
                url: $("#btn").data("url"),
                type: "post",
                data: data,/*{_data: formdata, _token: $("#btn").data("token"), _method: "post"},*/
                processData: false,
                contentType: false,
                beforeSend: function (xhr) {
                    var token = $("#btn").data("token");//this.data._token;
                    if (token) {
                        return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                    }
                },
                success: function (res) {
                    document.getElementById("response").innerHTML = res;
                }
            });
        }
    }, false);
}());
