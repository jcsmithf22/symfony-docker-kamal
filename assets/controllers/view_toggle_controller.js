import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["button", "grid"];

    // connect() {
    //     const viewMode = this.getCookie("view_mode") || "grid";
    //     this.applyViewMode(viewMode);
    // }

    toggle() {
        const currentMode = this.getCookie("view_mode") || "grid";
        const newMode = currentMode === "grid" ? "list" : "grid";

        this.setCookie("view_mode", newMode);
        this.applyViewMode(newMode);
    }

    applyViewMode(mode) {
        const state = (mode === "list").toString();
        this.gridTarget.dataset.list = state;
        this.buttonTarget.dataset.toggle = state;
    }

    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(";").shift();
    }

    setCookie(name, value) {
        const expires = new Date(Date.now() + 365 * 864e5).toUTCString();
        const cookie = `${name}=${value}; expires=${expires}; path=/; samesite=strict`;
        document.cookie =
            window.location.protocol === "https:"
                ? cookie + "; secure"
                : cookie;
    }
}
