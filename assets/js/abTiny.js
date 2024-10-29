(function() {
    tinymce.create("tinymce.plugins.InsertWeather_button", {
        init: function(ed, url) {
            ed.addButton("InsertWeather", {
                title: "Insert weather shortcode",
                cmd: "abs_weather_add",
                image: "https://cdn2.iconfinder.com/data/icons/crystalproject/32x32/apps/kweather.png"
            });
            ed.addCommand("abs_weather_add", function() {
                var abs_shortcode = "[abs-weather]";
                ed.execCommand("mceInsertContent", 0, abs_shortcode);
            });
        },
    });
    tinymce.PluginManager.add("InsertWeather_button", tinymce.plugins.InsertWeather_button);
})();