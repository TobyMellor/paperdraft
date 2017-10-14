class Utils {
    getArrayInArrayPosition(arrayToSearch, arrayToFind) {
        for (let i = 0; i < arrayToSearch.length; i++) {
            if (arrayToSearch[i][0] == arrayToFind[0] && arrayToSearch[i][1] == arrayToFind[1]) {
                return i;
            }
        }

        return -1;
    }

    isArrayInArray(arrayToSearch, arrayToFind) {
        if (this.getArrayInArrayPosition(arrayToSearch, arrayToFind) > -1) {
            return true;
        }

        return false;
    }

    isValidJson(jsonResponse) {
        return $.isPlainObject(jsonResponse);
    }

    getQueryParams() {
        var queryString = {},
            query       = window.location.search.substring(1),
            vars        = query.split("&");

        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");

            // If first entry with this name
            if (typeof queryString[pair[0]] === "undefined") {
                queryString[pair[0]] = decodeURIComponent(pair[1]);
            } else if (typeof queryString[pair[0]] === "string") {
                var arr = [queryString[pair[0]], decodeURIComponent(pair[1])];
                queryString[pair[0]] = arr;
            } else {
                queryString[pair[0]].push(decodeURIComponent(pair[1]));
            }
        } 

        return queryString;
    }

    isInt(value) {
        return !isNaN(value) && 
            parseInt(Number(value)) == value && 
            !isNaN(parseInt(value, 10));
    }

    doesEveryElementHaveChildren(array) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].length === 0) {
                return false;
            }
        }
        
        return true;
    }
}

$.fn.exchangePositionWith = function(selector) {
    var other = $(selector);

    this.after(other.clone());
    other.after(this).remove();
};

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};