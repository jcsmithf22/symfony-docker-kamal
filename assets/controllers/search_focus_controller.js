import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["searchInput"];

    connect() {
        this.shouldClear = false;
        document.addEventListener("keydown", this.handleKeydown);
        document.addEventListener("turbo:frame-load", this.handleFrameLoad);
    }

    disconnect() {
        document.removeEventListener("keydown", this.handleKeydown);
        document.removeEventListener("turbo:frame-load", this.handleFrameLoad);
    }

    markClear() {
        this.shouldClear = true;
    }

    handleKeydown = (event) => {
        if (event.key === "/" && !this.isInputFocused()) {
            event.preventDefault();
            this.dispatch("open-search");
            this.focusAndSelectSearch();
        }
    };

    handleFrameLoad = (event) => {
        if (event.target.id === "products") {
            const searchInput = this.searchInputTarget;
            if (this.shouldClear) {
                searchInput.value = "";
                searchInput.focus();
                this.shouldClear = false;
            } else {
                searchInput.focus();
                searchInput.select();
            }
        }
    };

    isInputFocused() {
        const activeElement = document.activeElement;
        return (
            activeElement &&
            (activeElement.tagName === "INPUT" ||
                activeElement.tagName === "TEXTAREA" ||
                activeElement.contentEditable === "true")
        );
    }

    focusAndSelectSearch() {
        const searchInput = this.searchInputTarget;
        if (searchInput) {
            searchInput.focus();
            searchInput.select();
        }
    }
}
