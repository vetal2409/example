(function () {
    $.fn.mailer = function (opt) {
        var defaults = {
            mailer_url: '/extensions/MailerTemplate'
        };
        var options = $.extend({}, defaults, opt);

        return this.each(function () {
            var body = $("body");
            var self = $(this);
            var $createListButton = $('.create-list-button');
            var ids = [];
            body.prepend('<div id="mailer-wrapper" class="reveal-modal"><div class="loader"></div><div id="mailer-content"></div><div id="mailer-result"></div><a class="close-reveal-modal">&#215;</a></div>');
            var mailer_wrapper = $('#mailer-wrapper');
            var mailer_content = $('#mailer-content');
            var mailer_result = $('#mailer-result');
            var mail_form_table, template_id, language_template;
            var showList = false;
            var embeddedImages = null;
            var attachments = null;
            var countAll = 0;
            var countNew = 0;
            var countSuccess = 0;
            var countError = 0;
            var $beforeTable = $('.before-table');
            var u = new Url();

            /* Begin Create list form */
            var $createListForm = $('<div class="create-list-form">\
            <div class="row">\
            <div class="col-lg-6">\
            <label for="and-where" class="hidden"></label>\
            <input type="text" id="and-where" class="form-control"/>\
            </div>\
            <div class="col-lg-1">\
            <button class="btn btn-info" id="and-where-button">Search</button>\
            </div>\
            <div class="col-lg-3">\
            <label for="list-name" class="hidden"></label>\
            <input type="text" id="list-name" class="form-control"/>\
            </div>\
            <div class="col-lg-1">\
            <button class="btn btn-info" id="list-name-button">Save</button>\
            </div>\
            <div class="col-lg-1">\
            <button class="btn btn-info list-form-close">Close</button>\
            </div>\
            </div>\
            </div>');
            var $andWhere = $createListForm.find('#and-where');
            var $andWhereButton = $createListForm.find('#and-where-button');
            var $listName = $createListForm.find('#list-name');
            var $listNameButton = $createListForm.find('#list-name-button');
            var $listFormClose = $createListForm.find('.list-form-close');
            var found = true;

            $beforeTable.append($createListForm);
            if (u.query.andWhere !== undefined) {
                $andWhere.val(decodeURIComponent(escape(window.atob(u.query.andWhere))));
                $createListForm.show();
            }

            // Show or Hide create list form
            $createListButton.click(function () {
                $createListForm.slideToggle();
            });
            $listFormClose.click(function () {
                delete u.query.andWhere;
                redirectByUrl();
            });

            $andWhere.change(function () {
                found = false;
            });

            $andWhere.keydown(function (event) {
                if (event.which === 13) {
                    findByAndWhere();
                }
            });

            $andWhereButton.click(function () {
                findByAndWhere();
            });

            $listName.keydown(function (event) {
                if (event.which === 13) {
                    saveList();
                }
            });

            $listNameButton.click(function () {
                saveList();
            });

            function findByAndWhere() {
                var andWhere = $andWhere.val();
                if (andWhere) {
                    u.query.andWhere = window.btoa(unescape(encodeURIComponent(andWhere)));
                } else if (u.query.andWhere !== undefined) {
                    delete u.query.andWhere;
                }
                redirectByUrl();
            }

            function saveList() {
                var listName = $listName.val();
                if (listName && found && u.query.andWhere && confirm('Do you really want to save this list?')) {
                    $.ajax({
                        url: options.mailer_url + "/save_list_save.php",
                        type: 'post',
                        data: {listName: listName, andWhereUrlEncode: u.query.andWhere},
                        cache: false,
                        success: function (response) {
                            if (response === 'EXIST') {
                                alert('The list with name "' + listName + '" already exist!')
                            } else if (response === 'ERROR') {
                                alert('Error!')
                            } else if (response === 'SUCCESS') {
                                alert('List saved successful!');
                            }
                        }
                    });
                }
            }

            /* End Create list form */

            function redirectByUrl() {
                location.href = u;
            }

            $.get(options.mailer_url + "/form.php", function (data) {
                mailer_content.html(data);
                var mail_form = $(".mail-form");
                var template = mail_form.find('#template');
                language_template = mail_form.find('#language-template');
                mail_form_table = mail_form.find('table#table_reg');
                var $attachmentList = $('.attachment-list');

                template.change(function () {
                    template_id = template.val();
                    loadTemplate($(this));
                });

                language_template.change(function () {
                    loadTemplate($(this));
                });

                function loadTemplate(that) {
                    if (that.val() === '')
                        return clearFrom();

                    var data = {};
                    data.type = that[0].id;
                    data.template_id = template_id;
                    if (data.type === 'language-template')
                        data.file_language = language_template.val();

                    $.ajax({
                        url: options.mailer_url + "/_generate_body.php",
                        type: "POST",
                        data: data,
                        cache: false,
                        success: function (response) {
                            if (response) {
                                var obj_template = JSON.parse(response);
                                embeddedImages = obj_template.template.embedded_images;
                                attachments = obj_template.template.attachments;
                                var attachmentsListLi = '<li>none</li>';
                                if (attachments && attachments.trim()) {
                                    var attachmentsList = attachments.split('|');
                                    attachmentsListLi = '';
                                    attachmentsList.forEach(function (attachment) {
                                        var attachmentParts = attachment.split('=');
                                        var attachmentNamePathList = attachmentParts[attachmentParts.length - 1].split('/');
                                        attachmentsListLi += '<li>' + attachmentNamePathList[attachmentNamePathList.length - 1] + '</li>';
                                    });
                                }
                                $attachmentList.html(attachmentsListLi);

                                if (obj_template.template) {
                                    for (var key in obj_template.template) {
                                        if (key == 'body') {
                                            body_editor.setData(obj_template.template[key]);
                                        }
                                        else {
                                            mail_form.find('[name=' + key + ']').val(obj_template.template[key]);
                                        }
                                    }
                                }
                                else {
                                    clearFrom();
                                }

                                if (obj_template.language_content !== undefined)
                                    language_template.html(obj_template.language_content);
                            }
                        },
                        error: function () {
                            alert("ERROR")
                        }
                    });
                    return true;
                }

                function clearFrom() {
                    mail_form.find("input").val('');
                    language_template.html('');
                    body_editor.setData('');
                }
            });


            self.click(function () {
                toggleModalBlocks("start");
                ids = [];
                var allCheckbox = $("input.checkbox-column:checked");
                if (allCheckbox.length > 0) {
                    allCheckbox.each(function () {
                        ids.push($(this).val());
                    });
                    if (showList) {
                        $('.tr-list').remove();
                        showList = false;
                    }
                } else {
                    if (!showList) {
                        $.get(options.mailer_url + "/parts/_lists_option.php", function (listOptions) {
                            mail_form_table.prepend('<tr class="tr-list"><td><label for="list">List:</label></td><td><select name="list" id="list">' + listOptions + '</select></td></tr>');
                            showList = true;
                        });
                    }
                }
                mailer_wrapper.reveal({
                    animation: 'fadeAndPop',
                    animationspeed: 300,
                    closeonbackgroundclick: true,
                    dismissmodalclass: 'close-reveal-modal'
                })
            });

            function toggleModalBlocks(status) {
                if (status == "start") {
                    mailer_content.show();
                    mailer_result.hide();
                }
                else if (status == "finish") {
                    mailer_content.hide();
                    mailer_result.show();
                }
            }

            mailer_content.on("submit", ".mail-form", function (event) {
                if ((!showList || mail_form_table.find('#list').val()) && template_id) {
                    sendMails($(this).serialize())
                }
                event.preventDefault();
            });

            function sendMails(serialize, sendStatus) {
                $.ajax({
                    url: options.mailer_url + "/send.php",
                    type: "POST",
                    data: {
                        form_data: serialize,
                        ids: ids,
                        template_id: template_id,
                        embedded_images: embeddedImages,
                        attachments: attachments,
                        sendStatus: sendStatus,
                        language: language_template.val()
                    },
                    dataType: 'json',
                    cache: false,
                    beforeSend: function () {
                        $('.loader').show();
                    },
                    success: function (response) {
                        if (response.type === 'list') {
                            toggleModalBlocks("finish");
                            if (response.sendStatus === 'start') {
                                countAll = response.countAll;
                                countNew = response.countNew;
                                countSuccess = response.success_count;
                                countError = response.error_count;
                                toggleModalBlocks("finish");
                                sendMails(serialize, 'pack');
                            }
                            else if (response.sendStatus === 'pack') {
                                countSuccess += response.success_count;
                                countError += response.error_count;
                                sendMails(serialize, response.sendStatus);
                            } else if (response.sendStatus === 'end') {
                                if (countAll <= 0) {
                                    countAll = response.countAll;
                                }
                                $('.loader').hide();
                            }
                            mailer_result.html(countAll + ' All\n<br/>' + countNew + ' In process\n<br/>' + countSuccess + ' Mails sent\n<br/>' + countError + ' Errors');
                        } else {
                            mailer_result.html(response.success_count + ' Mails sent\n<br/>' + response.error_count + ' Errors');
                            toggleModalBlocks("finish");
                            $('.loader').hide();
                        }
                    }
                });
            }


            ////// E


        });

    };
})(jQuery);