export function paddingLeft(str, length) {
    str = str.toString()
    if (str.length >= length)
        return str;
    else
        return paddingLeft("0" + str, length);
}