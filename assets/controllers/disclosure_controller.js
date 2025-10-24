// app/javascript/controllers/disclosure_controller.js
import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["details", "button"];
    static values = {
        openLabel: String,
        closedLabel: String,
    };

    connect() {
        this.updateButtonLabel();
    }

    toggle() {
        this.detailsTarget.open = !this.detailsTarget.open;
        this.updateButtonLabel();
    }

    updateButtonLabel() {
        this.buttonTarget.textContent = this.detailsTarget.open
            ? this.openLabelValue
            : this.closedLabelValue;
    }
}
