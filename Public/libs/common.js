/**
 * Form set Array to Key-value
 * @param {type} data
 * @returns {unresolved}
 */
function objToArray(data) {
    var o = {};
    $.each(data, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}

/**
 * 设置cookie
 * @param {type} name
 * @param {type} value
 * @returns {undefined}
 */
function setCookie(name, value) {
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";path=/;expires=" + exp.toGMTString();
}

/**
 * 获取cookie
 * @param {type} name
 * @returns {unresolved}
 */
function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) {
        return unescape(arr[2]);
    }
    return null;
}

/**
 * 删除cookie
 * @param {type} name
 * @returns {undefined}
 */
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if (cval !== null)
        document.cookie = name + "=" + cval + ";path=/;expires=" + exp.toGMTString();
}

/**
 * 获取时间戳
 * @returns {undefined}
 */
function getTimes() {
    return Math.round(new Date().getTime() / 1000);
}

function getUnixTime() {
    var timestamp = Math.round(new Date().getTime() / 1000);
    return timestamp;
}

/**
 * ajax自动加载跳转
 * @param {type} configURL
 * @param {type} data
 * @returns {undefined}
 */
function ajaxRt(configURL, data) {
    $.ajax({
        url: configURL,
        type: "POST",
        data: data,
        dataType: "json",
        success: function (res) {
            console.log(res);
            if (res.status !== 1) {
                alert(res.msg);
                return;
            }
            if (res.data === 1) {
                window.location.reload();
                return;
            }
            window.location.href = res.data;
        },
        error: function (st) {
            console.log(st);
        }
    });
}

/**
 * SUI-ajax自动加载跳转
 * @param {type} configURL
 * @param {type} data
 * @returns {undefined}
 */
function suiAjaxRt(configURL, data) {
    $.ajax({
        url: configURL,
        type: "POST",
        data: data,
        dataType: "json",
        success: function (res) {
            if (res.status !== 1) {
                $.alert(res.msg);
                return;
            }
            if (res.data === 1) {
                $.alert(res.msg, function () {
                    window.location.reload();
                });
                return;
            }
            window.location.href = res.data;
        },
        error: function (st) {
            console.log(st);
        }
    });
}

/**
 * databales
 * @param {type} clous
 * @param {type} url
 * @returns {undefined}
 */
function dTables(clous, url) {
    $('#datatables').dataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        oLanguage: {
            sSearch: "搜索",
            sLengthMenu: "每页显示 _MENU_ 条记录",
            sZeroRecords: "没有检索到数据",
            sInfo: "显示 _START_ 至 _END_ 条 &nbsp;&nbsp;共 _TOTAL_ 条",
            sInfoFiltered: "(筛选自 _MAX_ 条数据)",
            sInfoEmtpy: "没有数据",
            sProcessing: "正在加载数据...",
            oPaginate: {
                sFirst: "首页",
                sPrevious: "前一页",
                sNext: "后一页",
                sLast: "末页"
            }
        },
        aoColumns: clous,
    });
}


