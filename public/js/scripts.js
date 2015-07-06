$(document).ready(function () {
    var url_delete = "";
    var token = "";
    var url_pagato = "";
    var url_aggiorna = "";
    /*********************/
    /*funzioni per eventi*/
    /*********************/
    /*check if image type*/
    function isImageFile(file) {
        if (file.type) {
            return /^image\/\w+$/.test(file.type);
        } else {
            return /\.(jpg|jpeg|png|gif)$/.test(file);
        }
    }

    /*funzione ricerca elemento per campo*/
    function ricercaProdotto(url, token, record) {
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                _method: "POST",
                term: record,
                _token: token
            },
            cache: false,
            success: function (data) {
                openModalCatalogDetail(data);
            }, //end function
            error: function (data) {
                console.log(data);
            }
        });

    }

    /*funzione di inserimento prodotto in catalogo*/
    function aggiungiProdotto() {
        var id = $(".highlight").children('td').eq(0).text();
        var codice = $(".highlight").children('td').eq(1).text();
        var titolo = $(".highlight").children('td').eq(2).text();
        $("#id-prodotto").val(id);
        $("#codice").val(codice);
        $("#titolo").val(titolo);
        $('#lista-prodotti').modal('hide');
    }

    /*apro finestra modale per aggiunta prodotti a catalogo*/
    function openModalCatalogDetail(data) {
        var param = ""
        for (var i = 0; i < data.length; i++) {
            var obj = data[i];
            param += '<tr class="tr-lista-prodotti"><td style="display:none;">' + obj.id + '</td><td>' + obj.codice + '</td><td>' + obj.titolo + '</td></tr>';
        }
        param = $(param);
        $('#tbody-lista-prodotti').empty();
        $('#tbody-lista-prodotti').append(param);
        $('#lista-prodotti').modal('show');
    }
    ;
    /*chiedo conferma per cancellazione*/
    function cancellaClickHandler(event) {
        $('#msg-warning').modal('show');
    }

    /*cancello,categoria,elemento*/
    function eliminaElemento() {
        $.ajax({
            url: url_delete,
            type: 'post',
            data: {_method: 'delete', _token: token},
            context: document.body,
            cache: false,
            success: function (data) {
                $('#msg-warning').modal('hide');
                location.reload();
            },
            error: function (data) {
                $('#msg-warning').modal('hide');

            }
        });
    }

    /*aggiungo un prodotto al catalogo dal dettaglio*/
    function addProductToCatalog(event) {
        event.preventDefault();
        var index = $("#tabella-prodotti-listino tr").length;
        var prodotto = $("#id-prodotto").val();
        var codice = $("#codice").val();
        var listino = $("#id-listino").val();
        var titolo = $("#titolo").val();
        var prezzo = $("#prezzo").val();
        var sconto = $("#sconto").val();
        var token = $("#btn-aggiungi-prodotto").data("token");
        $.ajax({
            type: "POST",
            url: "prodotto/aggiungi",
            dataType: "json",
            data: {
                _method: "POST",
                index: index,
                prodotto: prodotto,
                listino: listino,
                codice: codice,
                titolo: titolo,
                prezzo: prezzo,
                sconto: sconto,
                _token: token
            },
            cache: false,
            beforeSend: function () {
                //$("#ajax_message").html("<p>Please wait...</p>").show();
            },
            success: function (data) {
                console.log(data);
                var data_append = $(data.msg);
                $("#codice").val("");
                $("#titolo").val("");
                $("#prezzo").val("");
                $("#sconto").val("");
                $("#id-prodotto").val("");
                $("#tabella-prodotti-listino tbody").append(data_append);
            }, //end function
            error: function (data) {
                console.log(data);
            }

        });
    }
    ;

    /*modifico prodotto del catalogo */
    function editProductOnCatalog(product_id, price, discount, token) {
        var prodotto = product_id;
        var prezzo = price;
        var sconto = discount;
        $.ajax({
            type: "POST",
            url: "prodotto/aggiorna",
            dataType: "json",
            data: {
                _method: "POST",
                prodotto: prodotto,
                prezzo: prezzo,
                sconto: sconto,
                _token: token
            },
            cache: false,
            beforeSend: function () {
                //$("#ajax_message").html("<p>Please wait...</p>").show();
            },
            success: function (data) {
                console.log(data);
                $('#msg-product').modal('hide');
                location.reload();

            }, //end function
            error: function (data) {
                console.log(data);
                $('#msg-product').modal('hide');
            }

        });
    }
    /*gestione eventi*/
    /*click su bottone "Elimina" in lista oggetti*/
    $(document).on("click", ".btn-cancella", function (event) {
        event.preventDefault();
        url_delete = $(this).attr("href");
        token = $(this).data('token');
        cancellaClickHandler(event);
    });
    /*click su bottone "Conferma" in modale per cancellazione degli oggetti*/
    $(document).on("click", "#btn-conferma", eliminaElemento);
    /*click su bottone "Aggiungi Prodotto" in modale per aggiunta degli oggetti in catalogo*/
    $(document).on("click", "#btn-inserisci-prodotto", aggiungiProdotto);
    /*selezione del prodotto dalla finestra modale per inserimento in catalogo*/
    $(document).on('click', "#tabella-lista-prodotti tr", function () {
        $("#tbody-lista-prodotti tr").removeClass("highlight");
        $(this).closest('tr').addClass("highlight");
    });
    $(document).on("click", "#btn-aggiungi-prodotto", function (event) {
        event.preventDefault();
        addProductToCatalog(event);
    });

    /*click sul pulsante conferma modifica prodotto in listino dettaglio*/
    $(document).on("click", "a#btn-conferma-prod", function (event) {
        event.preventDefault();
        var prodotto = $("#modifica-id").val();
        var prezzo = $("#modifica-prezzo").val();
        var sconto = $("#modifica-sconto").val();
        var token = $(this).data("token");
        editProductOnCatalog(prodotto, prezzo, sconto, token);
    });
    /*click su pulsante per modificare elemento in listino detail*/
    $(document).on("click", "a.btn-edit-list-prod", function (event) {
        event.preventDefault();
        var code = $(this).closest("tr").children(".detail-code").text();
        var name = $(this).closest("tr").children(".detail-name").text();
        var price = $(this).closest("tr").children(".detail-price").text();
        var discount = $(this).closest("tr").children(".detail-discount").text();
        var product = $(this).data("detail");
        if (price == null || price == "") {
            return;
        }
        if (discount == null || discount == "") {
            return;
        }

        $("#modifica-titolo").text($("#modifica-titolo").text() + ' - ' + code + ' - ' + name);
        $("#modifica-id").val(product);
        $("#modifica-prezzo").val(price);
        $("#modifica-sconto").val(discount);
        $("#modifica-id").val(product);
        $('#msg-product').modal('show');
    });

    /*click su pulsante per cancellare elemento in listino detail*/
    $(document).on("click", "a.btn-del-list-prod", function (event) {
        event.stopPropagation();
        event.preventDefault();
        $('#msg-warning').modal('show');
    });
    /*click pulsante panel su dashboard*/
    $(document).on("click", ".dash-head", function () {
        $(this).closest(".panel").find(".dash-detail").fadeToggle();
    });
    /*click sul pulsante elimina del carrello su elemento*/
    $(document).on("click", ".btn-del-item-cart", function (event) {
        event.preventDefault();
        url_delete = $(this).attr("href");
        token = $(this).data('token');
        eliminaElemento();
    });
    /*click su aggiorna elemento per quantità*/
    $(document).on("click", "#btn-refresh-cart", function (event) {
        event.preventDefault();
        alert("aggiorna carrello");
    });

    /*click su panel per ordini cliente*/
    $(document).on("click", ".tab-ordini-cliente", function (event) {
        event.preventDefault();
        var $id = $(this).attr("href");
        $($id).tab('show');
    });

    /*cambio di stato*/
    $(document).on("change", "#nuovo-stato", function () {
        var value = $(this).val();
        if (value === "3") {
            $(".div-tracking").show();
        } else {
            $(".div-tracking").hide();
        }
        $(".div-note-stato").show();
    });

    /*click sul pulsante pagato*/
    $(document).on("click", ".btn-pagato", function (event) {
        event.preventDefault();
        var order_number = $(this).data("order");
        url_pagato = $(this).attr("href");
        $("#pagamento-ordine-n").html(order_number);
        $("#msg-pagamento").modal("show");
    });

    /*click su pulsante conferma pagamento*/
    $(document).on("click", "#btn-conferma-pagamento", function (event) {
        event.preventDefault();
        var token = $(this).data("token");
        $('#msg-pagamento').modal('hide');
        $.blockUI({message: $('#wait-msg')});
        $.ajax({
            type: "POST",
            url: url_pagato,
            dataType: 'json',
            data: {
                _method: "POST",
                _token: token
            },
            cache: false,
            success: function (data) {
                location.reload();

            }, //end function
            error: function (data) {
                console.log(data);
            }

        });
    });

    /*jquery ui - data picker*/
    $("#data-inizio").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        regional: "it",
        dateFormat: "dd-mm-yy",
        onClose: function (selectedDate) {
            $("#to").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#data-fine").datepicker({
        defaultDate: "+1y",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: "dd-mm-yy",
        onClose: function (selectedDate) {
            $("#from").datepicker("option", "maxDate", selectedDate);
        }
    });

    /*click sul pulsante degli indirizzi*/
    $(document).on("click", ".address-list", function () {
        /*aggiungo il destinatario all'input nascosto */
        var id_destinatario = $(this).children(".destinatario-item").val();
        $("#destinatario").val(id_destinatario);
        /*devo nascondere tutti e aggiungere al address-place il div*/
        $(".address-container").hide();
        var new_item = $(this).clone().appendTo(".address-place");
        $(new_item).show();
        var tmp = $(new_item).find(".address-change:first");
        tmp.show();
        $(".address-add").hide();
        $(new_item).removeClass("panel-primary").addClass("panel-success");
        if ($(".travel-selection")[0]) {
            $(".travel-selection").show();//delay(2000).fadeIn(600);
        } else {
            if ($(".payment-selection")[0]) {
                $(".payment-selection").show();//delay(1000).fadeIn("slow");
            } else {
                $("#btn-conferma-ordine").show();//delay(1000).fadeIn("slow");
            }
        }
    });
    /*click sul pulsante della spedizione*/
    $(document).on("click", ".travel-item", function () {
        /*aggiungo il metodo di spedizione e il prezzo all'input nascosto */
        var prezzo_spedizione = $(this).children(".prezzo-spedizione").val();
        $("#handling").val(prezzo_spedizione);
        $(this).attr('disabled', 'disabled');
        var id_spedizione = $(this).children(".spedizione-item").val();
        $("#spedizione").val(id_spedizione);
        /*devo nascondere tutti e aggiungere al address-place il div*/
        $(".travel-container").hide();
        var new_item = $(this).clone().appendTo(".travel-place");
        $(new_item).show();
        var tmp = $(new_item).find(".travel-change:first");
        tmp.show();
        $(new_item).removeClass("panel-primary").addClass("panel-success");

        if ($(".payment-selection")[0]) {
            $(".payment-selection").show();//delay(1000).fadeIn("slow");
        } else {
            $("#btn-conferma-ordine").show();//delay(1000).fadeIn("slow");
        }
    });
    /*click sul pulsante dei pagamenti*/
    $(document).on("click", ".payment-item", function () {
        /*aggiungo il metodo di spedizione e il prezzo all'input nascosto */
        var id_pagamento = $(this).children(".pagamento-item").val();
        $("#pagamento").val(id_pagamento);
        /*devo nascondere tutti e aggiungere al address-place il div*/
        $(".payment-container").hide();
        var new_item = $(this).clone().appendTo(".payment-place");
        $(new_item).show();
        var tmp = $(new_item).find(".payment-change:first");
        tmp.show();
        $(new_item).removeClass("panel-primary").addClass("panel-success");
        $("#btn-conferma-ordine").show();//delay(1000).fadeIn("slow");
    });

    /*click sui pulsanti di cambio indirizzo/pagamento/spedizione su conferma ordine*/
    $(document).on("click", ".address-change", function (event) {
        event.preventDefault();
        $("#btn-conferma-ordine").hide();//delay(1000).fadeIn("slow");    
        $(this).closest(".panel-success").remove();
        $(".address-container").show();//fadeOut("slow");        
        $(".address-add").show();//fadeOut("slow");
        return false;
    });

    $(document).on("click", ".travel-change", function (event) {
        event.preventDefault();
        $("#btn-conferma-ordine").hide();//delay(1000).fadeIn("slow");    
        $(this).closest(".panel-success").remove();
        $(".travel-container").show();//fadeOut("slow");    
        return false;
    });

    $(document).on("click", ".payment-change", function (event) {
        event.preventDefault();
        $("#btn-conferma-ordine").hide();//delay(1000).fadeIn("slow");    
        $(this).closest(".panel-success").remove();
        $(".payment-container").show();//fadeOut("slow");        
        return false;
    });

    /*click sul pulsante dettaglio in lista ordini admin*/
    $(document).on("click", ".btn-order-detail", function (event) {
        event.preventDefault();
        $("#dettaglio-ordine-body").empty();
        var url = $(this).attr("href");
        var token = $(this).data("token");
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                _method: "POST",
                _token: token
            },
            cache: false,
            success: function (data) {
                $("#dettaglio-ordine-body").append(data);
                $('#dettaglio-ordine').modal('show');
            }, //end function
            error: function (data) {
                console.log(data);
            }

        });
    });
    /*click sul pulsante chiudi dettaglio nella finestra modale dettaglio-ordine*/
    $(document).on("click", "#btn-chiudi-dettaglio", function () {
        $('#dettaglio-ordine').modal('hide');
    });

    /*click sul pulsante aggiorna in lista ordini admin*/
    $(document).on("click", ".btn-aggiorna-ordine", function (event) {
        event.preventDefault();
        $("#msg-aggiorna-content").empty();
        var url = $(this).attr("href");
        var token = $(this).data("token");
        url_aggiorna = $(this).data("aggiorna");
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            data: {
                _method: "POST",
                _token: token
            },
            cache: false,
            success: function (data) {
                $("#msg-aggiorna-content").append(data);
                $('#aggiorna-ordine').modal('show');
            }, //end function
            error: function (data) {
                console.log(data);
            }

        });
    });
    /*click sul pulsante salva-aggiorna stato ordine*/
    $(document).on("click", "#btn-salva-aggiorna", function (event) {
        event.preventDefault();
        var stato = $("#nuovo-stato").val();
        var token = $(this).data("token");
        var note = $("#note-stato").val();
        var tracking = $("#tracking-stato").val();
        $.ajax({
            type: "POST",
            url: url_aggiorna,
            dataType: 'json',
            data: {
                stato: stato,
                note: note,
                tracking: tracking,
                _method: "POST",
                _token: token
            },
            cache: false,
            success: function (data) {
                $("#msg-aggiorna").modal("hide");
                location.reload();

            }, //end function
            error: function (data) {
                $("#msg-aggiorna").modal("hide");
                console.log(data);
            }

        });
    });

    /*click sul pulsante chiudi aggiorna nella finestra modale dettaglio-ordine*/
    $(document).on("click", "#btn-chiudi-aggiorna", function () {
        $('#aggiorna-ordine').modal('hide');
    });
    /*codice descrizione per prodotto*/
    /*click esplicito su pulsante*/
    $(document).on("click", ".btn-search", function (event) {
        event.preventDefault();
        var url = "";
        if ($(this).attr("id") == "search-code") {
            url = "prodotto/ricerca/codice/like";
            var record = $("#codice").val();
            var token = $("#codice").data('token');
        } else {
            url = "prodotto/ricerca/titolo/like";
            var record = $("#titolo").val();
            var token = $("#titolo").data('token');
        }

        ricercaProdotto(url, token, record);
    });

    $(document).on("click", ".btn-reset", function (event) {
        event.preventDefault();
        $("#codice").val("");
        $("#titolo").val("");
        $("#sconto").val("");
        $("#prezzo").val("");
    });

    /*change del campo quantità*/
    $(document).on("focusout", ".quantita", function () {
        $(".tr-error").remove();
        $.blockUI({message: $('#wait-msg')});
        var $quantita = $(this).val();
        var token = $(this).data('token');
        var $id_carrello = $(this).data("id");
        $.ajax({
            context: this, /*used for pass object dom into ajax*/
            url: $id_carrello,
            type: 'post',
            cache: false,
            data: {_method: 'put', quantita: $quantita, _token: token},
            success: function (data) {
                if (data.code === "200") {
                    location.reload();
                } else {
                    var $error = '<tr class="tr-error"><td class="alert alert-success" role="alert" colspan ="5">' + data.msg + '</td></tr>';
                    $(this).closest(".tr-carrello").prepend($error);
                }
            },
            error: function (data) {
            }
        });
    });
    /*click sul pulsante ricerca in home page*/
    $(document).on("click", ".search-btn", function (event) {
        event.preventDefault();
        $("#search-form").submit();
    });
    /*click sul pulsante di toggle dell'utente*/
    $(document).on("click", ".btn-toggle-usr", function (event) {
        event.preventDefault();
        $.blockUI({message: $('#wait-msg')});
        var url = $(this).attr("href");
        var token = $(this).data('token');
        $.ajax({
            context: this, /*used for pass object dom into ajax*/
            url: url,
            type: 'post',
            cache: false,
            data: {_method: 'post', _token: token},
            success: function (data) {
                if (data.code === "200") {
                    location.reload();
                } else {
                    $(document).ajaxStop($.unblockUI);
                }
            },
            error: function (data) {
                $(document).ajaxStop($.unblockUI);
            }
        });
    });

    /*blockui*/
    // unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI);

    /*venbox lightbox immagini prodotto*/
    /* default settings */
    $('.venobox').venobox();

    /*carousel*/
    $('#myCarousel').carousel({
        interval: 10000
    });

    $('.carousel .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        if (next.next().length > 0) {
            next.next().children(':first-child').clone().appendTo($(this));
        }
        else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });

    $(document).on("click", ".img-carousel", function (event) {
        event.preventDefault();
    });

    $(document).on("click", "#add-tag", function (event) {
        event.preventDefault();
        var $tagcontent = $("#tag-input").val();
        var $tagtmpl = '';
        var $count = $("#tag-container span").length;
        if ($tagcontent != "" && $tagcontent != null) {
            var $module = $count % 6;
            switch ($module) {
                case 0:
                    $tagtmpl = '<span class="label label-default">' + $tagcontent + '</span>';
                    break;
                case 1:
                    $tagtmpl = '<span class="label label-primary">' + $tagcontent + '</span>';
                    break;
                case 2:
                    $tagtmpl = '<span class="label label-success">' + $tagcontent + '</span>';
                    break;
                case 3:
                    $tagtmpl = '<span class="label label-info">' + $tagcontent + '</span>';
                    break;
                case 4:
                    $tagtmpl = '<span class="label label-warning">' + $tagcontent + '</span>';
                    break;
                case 5:
                    $tagtmpl = '<span class="label label-danger">' + $tagcontent + '</span><br><br>';
                    break;
            }
            $tagtmpl += '<input type="hidden" name="tags[]" value="' + $tagcontent + '" />';
            $("#tag-container").append($tagtmpl);
            $("#tag-input").val("");
        }

    });

    /*cookies law*/
    $.cookieBar({
        acceptText: 'Continua',
        policyButton: true,
        policyURL: '/privacy',
        effect: 'slide',
        message: "Questo sito utilizza cookies, anche di terze parti. Chiudendo questo banner, scorrendo questa pagina o cliccando qualunque suo elemento, acconsenti al loro impiego in conformità alla nostra Cookie Policy."
    });

    /*dropzone image uploader*/
    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
        dictDefaultMessage: "Trascina l'immagine qua per caricarla, oppure fai click per caricarla da una directory",
        headers: {"X-XSRF-TOKEN": "{!! csrf_token() !!}"},
        init: function () {
            this.on("addedfile", function (file) {
                var removeButton = Dropzone.createElement('<a class="dz-remove">Remove file</a>');
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var fileInfo = new Array();
                    fileInfo['name'] = file.name;
                    $.ajax({
                        type: "POST",
                        url: "{!! url('/immagini/delete') !!}",
                        data: {file: file.name},
                        beforeSend: function () {
                            // before send
                        },
                        success: function (response) {

                            if (response == 'success')
                                alert('deleted');
                        },
                        error: function () {
                            alert("error");
                        }
                    });
                    _this.removeFile(file);
                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });
                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
            });
        }
    };
});