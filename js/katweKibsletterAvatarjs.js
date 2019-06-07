function katweKibsAvatar() {
    this.selector = ".user-icon";
    this.dataChars = 1;
    this.width = 24;
    this.height = 24;

    this.colours = [
        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
        "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
        "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12",
        "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];


    this.init = function (obj) {
        if (obj) {
            if (obj.selector) {
                this.selector = obj.selector;
            }
            if (obj.dataChars) {
                this.dataChars = obj.dataChars;
            }

            if (obj.width) {
                this.width = obj.width;
            }
            if (obj.height) {
                this.height = obj.height;
            }
        }
        this.setCanvases();
        this.drawCanvas();
    };

    this.setCanvases = function () {
        this.canvases = $(this.selector);
    };

    this.getInitials = function (name, numChars) {
        var initials = name.charAt(0).toUpperCase()
        if (name.indexOf(" ") > -1 && numChars > 1) {
            var nameSplit = name.split(" ");
            initials = nameSplit[0].charAt(0).toUpperCase() + nameSplit[1].charAt(0).toUpperCase();
        }
        return initials;
    };

    this.getIndex = function (name) {
        var myindex = 0;
        if (name.indexOf(" ") > -1) {
            var nameSplit = name.split(" ");
            myindex = nameSplit[0].toUpperCase().charCodeAt(0) + nameSplit[1].toUpperCase().charCodeAt(nameSplit[1].length - 1);
        } else {
            myindex = name.toUpperCase().charCodeAt(0) + name.toUpperCase().charCodeAt(name.length - 1);
        }
        myindex = myindex % 19;
        return myindex;
    };

    this.getNumChars = function (numCharObj) {
        var numChars = 1;
        if (typeof numCharObj !== 'undefined' && Number.isInteger(parseInt(numCharObj))) {
            numChars = numCharObj;
        }
        return numChars;
    };

    this.draw = function (ind, myobj) {
        var canvas = $(myobj).get(0);
        var name = $(myobj).attr("data-name");

        if ($(canvas).attr("data-chars")) {
            var numChars = katweKibsAvatar.getNumChars($(canvas).attr("data-chars"));
        } else {
            var numChars = katweKibsAvatar.dataChars;
        }

        var initials = katweKibsAvatar.getInitials(name, numChars);
        var colourIndex = katweKibsAvatar.getIndex(name);
        var context = canvas.getContext("2d");

        if ($(canvas).attr("width")) {
            var canvasWidth = $(canvas).attr("width");
        } else {
            var canvasWidth = katweKibsAvatar.width;
        }

        if ($(canvas).attr("height")) {
            var canvasHeight = $(canvas).attr("height");
        } else {
            var canvasHeight = katweKibsAvatar.height;
        }

        var canvasCssWidth = canvasWidth;
        var canvasCssHeight = canvasHeight;

        if (window.devicePixelRatio) {
            $(canvas).attr("width", canvasWidth * window.devicePixelRatio);
            $(canvas).attr("height", canvasHeight * window.devicePixelRatio);
            $(canvas).css("width", canvasCssWidth);
            $(canvas).css("height", canvasCssHeight);
            context.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        context.fillStyle = katweKibsAvatar.colours[colourIndex];
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.font = (canvasWidth - canvasWidth * 45 / 100) + "px Arial ";
        context.textAlign = "center";
        context.fillStyle = "#FFF";
        context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.4);
    };

    this.drawCanvas = function () {
        if (this.canvases) {
            this.canvases.each(this.draw);
        }
    };
}

katweKibsAvatar = new katweKibsAvatar();

katweKibsAvatar.init({
	dataChars: 2,
	width: 100,
	height: 100
});
