async function uploadFileCloudinary(e, url_upload, target_id, isWaterMask = true, watermask = '', idCat = 0, color = '#ffffff', enabled = 1) {
    if (window.location.hostname.includes('-s3.')) {
        uploadFileCloudinary2(e, url_upload, target_id)
        return
    }
    if (e != null) {
        file = e.target.files[0]; if (!file.name.match(/.(jpg|jpeg|png|gif|bmp|webp|svg|heic|heif|hevc)$/i))
            return alert('HĂ¬nh áº£nh báº¡n táº£i lĂªn khĂ´ng Ä‘Ăºng Ä‘á»‹nh dáº¡ng file, vui lĂ²ng kiá»ƒm tra láº¡i (jpg, jpeg, png, bmp, gif)');
    }
    console.log(file)
    if (file.size > (1024 * 1024)) {
        const options = { maxSizeMB: 2, maxWidthOrHeight: 1920, useWebWorker: true }
        try { fileNew = await imageCompression(file, options); file = new File([fileNew], file.name); console.log(file) } catch (error) { console.log(error); }
    }
    if (file.size > (2 * 1024 * 1024)) { return alert('Dung lÆ°á»£ng file áº£nh quĂ¡ lá»›n -> YĂªu cáº§u file dung lÆ°á»£ng <= 2M') }
    var url = '//' + window.location.hostname + '/api/upload'
    if (window.location.hostname.includes('tuvichanco') || window.location.hostname.includes('.0.0')) { url = '//gozic.vn/api/upload' }
    var xhr = new XMLHttpRequest(); var fd = new FormData(); xhr.open('POST', url, true); xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); xhr.onreadystatechange = function (e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText)
            if (obj.status == 0) {
                alert(obj.msg)
                return
            }
            document.getElementById(target_id).value = obj.url; $("#" + target_id).trigger('change')
        }
    }; fd.append('tags', 'browser_upload'); if (e != null) { fd.append('file', file); }
    fd.append('isWaterMask', isWaterMask); fd.append('watermask', watermask); fd.append('idCat', idCat); fd.append('color', color); fd.append('enabled', enabled); xhr.send(fd);
}
async function uploadURLCloudinary(file, url_upload, callback, isWaterMask = true, watermask = '', idCat = 0, color = '#ffffff', enabled = 1) {
    if (window.location.hostname.includes('-s3.')) {
        uploadURLCloudinary2(file, url_upload, callback)
        return
    }
    if (file != null) {
        if (!file.name.match(/.(jpg|jpeg|png|gif|bmp|webp)$/i))
            return alert('HĂ¬nh áº£nh báº¡n táº£i lĂªn khĂ´ng Ä‘Ăºng Ä‘á»‹nh dáº¡ng file, vui lĂ²ng kiá»ƒm tra láº¡i (jpg, jpeg, png, bmp, gif)');
    }
    console.log(file)
    if (file.size > (1024 * 1024)) {
        const options = { maxSizeMB: 1, maxWidthOrHeight: 1920, useWebWorker: true }
        try { fileNew = await imageCompression(file, options); file = new File([fileNew], file.name); console.log(file) } catch (error) { console.log(error); }
    }
    if (file.size > (2 * 1024 * 1024)) { return alert('Dung lÆ°á»£ng file áº£nh quĂ¡ lá»›n -> YĂªu cáº§u file dung lÆ°á»£ng <= 2M') }
    var url = '//' + window.location.hostname + '/api/upload'
    if (window.location.hostname.includes('tuvichanco') || window.location.hostname.includes('.0.0')) { url = '//gozic.vn/api/upload' }
    var xhr = new XMLHttpRequest(); var fd = new FormData(); xhr.open('POST', url, true); xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); xhr.onreadystatechange = function (e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText)
            if (obj.status == 0) {
                alert(obj.msg)
                return
            }
            callback(obj.url)
        }
    }; fd.append('tags', 'browser_upload'); if (file != null) { fd.append('file', file); }
    fd.append('isWaterMask', isWaterMask); fd.append('watermask', watermask); fd.append('idCat', idCat); fd.append('color', color); fd.append('enabled', enabled); xhr.send(fd);
}
async function uploadFile(file, callback) {
    if (window.location.hostname.includes('-s3.')) {
        uploadURLCloudinary2(file, "", callback)
        return
    }
    if (file != null) {
        if (!file.name.match(/.(jpg|jpeg|png|gif|bmp|webp)$/i))
            return alert('HĂ¬nh áº£nh báº¡n táº£i lĂªn khĂ´ng Ä‘Ăºng Ä‘á»‹nh dáº¡ng file, vui lĂ²ng kiá»ƒm tra láº¡i (jpg, jpeg, png, bmp, gif)');
    }
    if (file.size > (30 * 1024 * 1024)) { return alert('Dung lÆ°á»£ng file áº£nh quĂ¡ lá»›n -> YĂªu cáº§u file dung lÆ°á»£ng <= 30M') }
    var url = '//' + window.location.hostname + '/api/upload'
    if (window.location.hostname.includes('tuvichanco') || window.location.hostname.includes('.0.0')) { url = '//gozic.vn/api/upload' }
    var xhr = new XMLHttpRequest(); var fd = new FormData(); xhr.open('POST', url, true); xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); xhr.onreadystatechange = function (e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText)
            if (obj.status == 0) {
                alert(obj.msg)
                return
            }
            callback(obj.url)
        }
    }; fd.append('tags', 'browser_upload'); if (file != null) { fd.append('file', file); }
    fd.append('isWaterMask', false); fd.append('watermask', ""); fd.append('idCat', 0); fd.append('color', ""); fd.append('enabled', 1); xhr.send(fd);
}
function uploadFileCloudinary2(e, url_upload, target_id) { file = e.target.files[0]; var url = `https://api.cloudinary.com/v1_1/ziczac-software/upload`; var xhr = new XMLHttpRequest(); var fd = new FormData(); xhr.open('POST', url, true); xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); xhr.onreadystatechange = function (e) { if (xhr.readyState == 4 && xhr.status == 200) { var response = JSON.parse(xhr.responseText); var url = response.secure_url; document.getElementById(target_id).value = url; $("#" + target_id).trigger('change') } }; fd.append('upload_preset', 'f79hwsdh'); fd.append('tags', 'browser_upload'); fd.append('file', file); xhr.send(fd); }
function uploadURLCloudinary2(file, url_upload, callback) {
    if (url_upload == null || url_upload == '') { url_upload = 'https://api.cloudinary.com/v1_1/wegoup/upload#e0b6fjvh' }
    var url = `https://api.cloudinary.com/v1_1/ziczac-software/upload`; var xhr = new XMLHttpRequest(); var fd = new FormData(); xhr.open('POST', url, true); xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); xhr.onreadystatechange = function (e) { if (xhr.readyState == 4 && xhr.status == 200) { var response = JSON.parse(xhr.responseText); var url = response.secure_url; callback(url) } }; fd.append('upload_preset', 'f79hwsdh'); fd.append('tags', 'browser_upload'); fd.append('file', file); xhr.send(fd);
}