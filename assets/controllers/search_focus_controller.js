import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["searchInput"];

    connect() {
        document.addEventListener("keydown", this.handleKeydown);
        document.addEventListener("turbo:frame-load", this.handleFrameLoad);
    }

    disconnect() {
        document.removeEventListener("keydown", this.handleKeydown);
        document.removeEventListener("turbo:frame-load", this.handleFrameLoad);
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
            this.focusAndSelectSearch();
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
