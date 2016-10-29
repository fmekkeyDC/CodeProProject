            </div>


            <!-- /#wrap -->
            <footer class="Footer bg-dark dker">
                <p>powered by CodePro System {{date("Y")}}</p>
            </footer>
            <!-- /#footer -->
            <!-- #helpModal -->
            <div id="helpModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">معلومات النظام</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                هذا النظام تم انشائه و برمجته بواسطة شركة (CodePro system) للبرمجة الخاصة و استضافة المواقع . <br>
                                العنوان : 7 شارع عبد الحميد سالم المتفرع من شكري القوتلي امام محل ميلانو للاحذية (سفن اليفن سابقا)<br>
                                جميع الحقوق محفوظه لشركة (CodePro system {{date("Y")}}) .
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
        </div>
    {{HTML::Script($public_path."js/jquery.min.js")}}
    <!-- Latest compiled and minified JavaScript -->
    {{HTML::Script($public_path."js/bootstrap.min.js")}}
    {{HTML::Script($public_path."js/moment.min.js")}}
    {{HTML::Script($public_path."js/jquery-ui.min.js")}}
    {{HTML::Script($public_path."js/jquery.validate.min.js")}}
    {{HTML::Script($public_path."js/holder.js")}}
    {{HTML::Script($public_path."js/jquery.uniform.min.js")}}
    {{HTML::Script($public_path."js/jasny-bootstrap.min.js")}}
    {{HTML::Script($public_path."js/jquery.form.min.js")}}
    {{HTML::Script($public_path."js/chosen.jquery.min.js")}}
    {{HTML::Script($public_path."js/jquery.tagsinput.min.js")}}
    {{HTML::Script($public_path."js/jquery.autosize.min.js")}}
    {{HTML::Script($public_path."js/bootstrap-switch.min.js")}}
    {{HTML::Script($public_path."js/metisMenu.min.js")}}
    {{HTML::Script($public_path."js/screenfull.min.js")}}
    {{HTML::Script($public_path."lib/plupload/js/plupload.full.min.js")}}
    {{HTML::Script($public_path."lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js")}}
    {{HTML::Script($public_path."lib/jquery.gritter/js/jquery.gritter.min.js")}}
    {{HTML::Script($public_path."lib/formwizard/js/jquery.form.wizard.js")}}
    {{HTML::Script($public_path."js/core.min.js")}}
    {{HTML::Script($public_path."js/app.js")}}
    {{HTML::Script($public_path."js/jquery.cookie.js")}}
    {{HTML::Script($public_path."js/jquery.hotkeys.js")}}
    {{HTML::Script($public_path."js/style-switcher.js")}}
    {{HTML::Script($public_path."js/bootstrap-datepicker.min.js")}}
    {{HTML::Script($public_path."js/bootstrap-colorpicker.min.js")}}
    {{HTML::Script($public_path."js/bootstrap-datetimepicker.min.js")}}
    {{HTML::Script($public_path."js/bootstrap-datepicker.ar.js")}}
    {{HTML::Script($public_path."js/screenfull.min.js")}}
    {{HTML::Script($public_path."lib/inputlimiter/jquery.inputlimiter.js")}}
    {{HTML::Script($public_path."lib/validVal/js/jquery.validVal.min.js")}}
    {{HTML::Script($public_path."lib/bootstrap-daterangepicker/daterangepicker.js")}}
    {{HTML::Script($public_path."js/jquery.dataTables.min.js")}}
    {{HTML::Script($public_path."js/dataTables.bootstrap.min.js")}}
    {{HTML::Script($public_path."js/jquery.tablesorter.min.js")}}
    {{HTML::Script($public_path."js/jquery.ui.touch-punch.min.js")}}
    {{HTML::Script($public_path."js/select2.js")}}
    {{HTML::Script($public_path."js/ar.js")}}
    {{HTML::Script($public_path."js/code39.js")}}
    {{HTML::Script($public_path."js/printThis.js")}}

    
    <script type="text/javascript">
        var sideOpened = "";
        function SetSession(id){
            sideOpened = $.cookie('sideOpened', id, { expires: 7, path: '/' });
        }

        $(function() {
            Metis.formGeneral();
        });

        function ajaxBrowsing(URL){
            $(document).unbind('keydown')
            $.ajax({
                type : 'get',
                dataType : 'html',
                url : URL,
                beforeSend : function(){
                    $(".browsingContent").empty();
                    var str = '<div class="browsingContent">';
                    str += '<div id="content">';
                    str += '<div class="outer">';
                    str += '<div class="inner bg-light lter" style="height: 1200px">';
                    str += '&nbsp; <i> <h3 class="" style="text-align:center;"> جاري التحميل </h3> </i>  <br>';
                    str += '<img src="{{$public_path}}img/gears.gif" class="img-responsive center-block img-rounded" width="75">';
                    str += '</div>';
                    str += '<!-- /.inner -->';
                    str += '</div>';
                    str += '<!-- /.outer -->';
                    str += '</div>';
                    str += '</div>';
                    $(".browsingContent").html(str);
                },
                success : function (data) {
                    $(document).unbind('keydown')
                    $(".browsingContent").empty();
                    $("#javascriptHolder").empty();
                    $(".browsingContent").html(data);
                    // $(":input").keypress(function(event){
                    //     if (event.which == '10' || event.which == '13') {
                    //         event.preventDefault();
                    //     }
                    // });

                    var BarcodeScanerEvents = function() {
                         this.initialize.apply(this, arguments);
                    };

                    BarcodeScanerEvents.prototype = {
                        initialize: function() {
                           $(document).on({
                              keyup: $.proxy(this._keyup, this)
                           });
                        },
                        _timeuotHandler: 0,
                        _inputString: '',
                        _keyup: function (e) {
                        if (this._timeuotHandler) {
                            clearTimeout(this._timeuotHandler);
                            this._inputString += String.fromCharCode(e.which);
                        } 

                        this._timeuotHandler = setTimeout($.proxy(function () {
                            if (this._inputString.length <= 3) {
                                this._inputString = '';
                                return;
                            }

                            $(document).trigger('onbarcodescaned', this._inputString);

                            this._inputString = '';

                        }, this), 20);
                        }
                    };
                    var elements = [];

                    if (URL.indexOf("add_items_to_store") != -1 || URL.indexOf("sell_invoice") != -1){
                        elements = [
                            "esc","tab","space","return","backspace","scroll","capslock","numlock","insert","home","del","end","pageup","pagedown",
                            "left","up","right","down",
                            "f1","f2","f3","f4","f5","f6","f7","f8","f9","f10","f11","f12",
                            "1","2","3","4","5","6","7","8","9","0",
                            "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z", 
                            "Ctrl+a","Ctrl+b","Ctrl+c","Ctrl+d","Ctrl+e","Ctrl+f","Ctrl+g","Ctrl+h","Ctrl+i","Ctrl+j","Ctrl+k","Ctrl+l","Ctrl+m",
                            "Ctrl+n","Ctrl+o","Ctrl+p","Ctrl+q","Ctrl+r","Ctrl+s","Ctrl+t","Ctrl+u","Ctrl+v","Ctrl+w","Ctrl+x","Ctrl+y","Ctrl+z",
                            "Shift+a","Shift+b","Shift+c","Shift+d","Shift+e","Shift+f","Shift+g","Shift+h","Shift+i","Shift+j","Shift+k","Shift+l",
                            "Shift+m","Shift+n","Shift+o","Shift+p","Shift+q","Shift+r","Shift+s","Shift+t","Shift+u","Shift+v","Shift+w","Shift+x",
                            "Shift+y","Shift+z",
                            "Alt+a","Alt+b","Alt+c","Alt+d","Alt+e","Alt+f","Alt+g","Alt+h","Alt+i","Alt+j","Alt+k","Alt+l",
                            "Alt+m","Alt+n","Alt+o","Alt+p","Alt+q","Alt+r","Alt+s","Alt+t","Alt+u","Alt+v","Alt+w","Alt+x","Alt+y","Alt+z",
                            "Ctrl+esc","Ctrl+tab","Ctrl+space","Ctrl+return","Ctrl+backspace","Ctrl+scroll","Ctrl+capslock","Ctrl+numlock",
                            "Ctrl+insert","Ctrl+home","Ctrl+del","Ctrl+end","Ctrl+pageup","Ctrl+pagedown","Ctrl+left","Ctrl+up","Ctrl+right",
                            "Ctrl+down",
                            "Ctrl+f1","Ctrl+f2","Ctrl+f3","Ctrl+f4","Ctrl+f5","Ctrl+f6","Ctrl+f7","Ctrl+f8","Ctrl+f9","Ctrl+f10","Ctrl+f11","Ctrl+f12",
                            "Shift+esc","Shift+tab","Shift+space","Shift+return","Shift+backspace","Shift+scroll","Shift+capslock","Shift+numlock",
                            "Shift+insert","Shift+home","Shift+del","Shift+end","Shift+pageup","Shift+pagedown","Shift+left","Shift+up",
                            "Shift+right","Shift+down",
                            "Shift+f1","Shift+f2","Shift+f3","Shift+f4","Shift+f5","Shift+f6","Shift+f7","Shift+f8","Shift+f9","Shift+f10","Shift+f11","Shift+f12",
                            "Alt+esc","Alt+tab","Alt+space","Alt+return","Alt+backspace","Alt+scroll","Alt+capslock","Alt+numlock",
                            "Alt+insert","Alt+home","Alt+del","Alt+end","Alt+pageup","Alt+pagedown","Alt+left","Alt+up","Alt+right","Alt+down",
                            "Alt+f1","Alt+f2","Alt+f3","Alt+f4","Alt+f5","Alt+f6","Alt+f7","Alt+f8","Alt+f9","Alt+f10","Alt+f11","Alt+f12","enter"
                        ];

                        $.each(elements, function(i, e) {
                           var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
                           
                            $(document).bind('keydown', elements[i], function assets() {
                                if (elements[i] == "enter"){
                                    $("#add_new_items").click();
                                }if (elements[i] == "up"){
                                    $(".tbodysellTable tr:last").remove();
                                }if (elements[i] == "Ctrl+s"){
                                    $("#addSellInvoice").trigger("submit");
                                }
                                return false;
                           });
                        });
                        @if(Auth::user()->users_rights != 4)
                            $(".date").attr("disabled","disabled");
                            $( '<input id="invoice_date" placeholder="التاريخ" class="form-control date" name="invoice_date" type="hidden">' ).insertAfter( ".date" ).val($(".date").val());
                            $(".date").datepicker("option", "disabled", true);
                        @endif
                    }else{
                        @if(Auth::user()->users_rights != 4)
                            $(".date").attr("disabled","disabled");
                            $( '<input id="date" placeholder="التاريخ" class="form-control date" name="date" type="hidden">' ).insertAfter( ".date" ).val($(".date").val());
                            $(".date").datepicker("option", "disabled", true);
                        @endif
                    }

                    $("#javascriptHolder").append(eval($(this).text()));


                },complete : function(){
                    // if (URL.indexOf("add_items_to_store") == -1  || URL.indexOf("sell_invoice") == -1){
                    //     $(document).unbind('keydown')
                    // }
                    // var obj = { Page: "Myzoo", Url: URL };
                    // history.pushState(obj, obj.Page, obj.Url);
                },error (e){
                    alert("لا تملك تصريح إستخدام هذا التطبيق");
                    window.location.reload();
                }
            })
        }


        $("#LIST_"+$.cookie('sideOpened')+"").addClass("active");

        $(".dropdown").on("click",function(){
            $(".dropdown-menu").css("display","none");
            $(this).find("ul").css("display","block");
        });

        $(".dropdown").on("click","a",function(){
            $("ul.dropdown-menu").fadeOut(100)
        });
        var loaded = 0
        

    </script>

    <div id="javascriptHolder"></div>
</body>
</html>
