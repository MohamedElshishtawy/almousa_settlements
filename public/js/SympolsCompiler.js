$(document).ready(function() {
    var replacements = [
        { "name": "power", "pattern": "(\\d+)\\^\\^([^\\s]+)", "replacement": "$1<sup>$2</sup>" },
        { "name": "root", "pattern": "\\(\\((\\d+)\\)\\)", "replacement": "√$1" },
        { "name": "root with power", "pattern": "(\\d)\\(\\((\\d+)\\)\\)", "replacement": "√$2<sup>$1</sup>" },
        { "name": "subscript", "pattern": "(\\d+)__(\\d+)", "replacement": "$1<sub>$2</sub>" },
        { "name": "omega", "pattern": "(omega)", "replacement": "Ω" },
        { "name": "sigma", "pattern": "(segma)", "replacement": "Σ" }
    ];

    function applyReplacements(text, replacements) {
        replacements.forEach(function(replacement) {
            var regex = new RegExp(replacement.pattern, "g");
            text = text.replace(regex, replacement.replacement);
        });
        return text;
    }

    let element = $(".question, .answer label");
    element.each(function () {
        let text = $(this).html();
        text = applyReplacements(text, replacements);
        $(this).html(text);

    })

});
