class ThemeToggler {
    trigger = null;
    class = "";
    themeBaseUrl = "";
    constructor() {
        this.trigger = document.getElementById("settings-js-dt-theme");
        this.nav = document.getElementById("nav");
    }
    run() {
        this.setEventListeners();
        this.setGlobalSidebar();   
    }

    setEventListeners() {
        if (!this.trigger) {
            return;
        }

        this.trigger.addEventListener("click", (e) => {
            this.class = e.target.value;
            this.onTriggerClick();
        });
    }

    onTriggerClick() {
        this.toggleClass();
        this.toggleStylesheet();
        this.toggleWidgets();
    }

    toggleClass() {
        document.body.classList.forEach((element) => {
            if (element.includes("dt-")) {
                document.body.classList.remove(element);
            }
        });

        document.body.classList.add(this.class);
    }

    toggleStylesheet() {
        let sheets = document.querySelectorAll("link[rel=stylesheet]");
        sheets.forEach((sheet, i) => {
            if (sheet.href.includes("dt-")) {
                this.themeBaseUrl = sheet.href.replace(/dt-.*/,'');
                sheets[i].remove();
            }
        });

        this.createStylesheet();
    }

    getIsActive(){
        return !document.body.classList.contains('dt-default');
    }

    getWidget(){
        return document.getElementById('js-dt-widget');
    }

    toggleWidgets(){
        if(!this.getIsActive()){
            this.getWidget()?.remove();
        } else {
            this.setGlobalSidebar();
        }
    }

    createStylesheet(){
        const head = document.getElementsByTagName("head")[0];
        const style = document.createElement("link");
        style.href = this.themeBaseUrl + this.class + ".min.css";
        style.type = "text/css";
        style.rel = "stylesheet";
        head.append(style);
    }

    setGlobalSidebar(){

        if(!this.getIsActive() || this.getWidget()){
            return;
        }

        const widget = document.createElement("div");
        const html = this.htmlEntities(window.__DT.widgetHtml);
        widget.innerHTML = html;
        this.nav.append(widget);
    }

    htmlEntities(htmlStr) {
        htmlStr = htmlStr.replace(/&lt;/g , "<");	 
        htmlStr = htmlStr.replace(/&gt;/g , ">");     
        htmlStr = htmlStr.replace(/&quot;/g , "\"");  
        htmlStr = htmlStr.replace(/&#39;/g , "\'");   
        htmlStr = htmlStr.replace(/&amp;/g , "&");
        return htmlStr;
    }
}


addEventListener("load", () => {
    let theme = new ThemeToggler();
    theme.run();
});
