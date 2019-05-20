window.siteUrl='';
// 解码  
function decodeUnicode(str) {  
    str = str.replace(/\\/g, "%");  
    return unescape(str);  
}  
 