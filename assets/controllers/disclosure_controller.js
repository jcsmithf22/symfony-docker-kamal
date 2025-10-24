// app/javascript/controllers/disclosure_controller.js
import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["details", "button"];
    static values = {
        openLabel: String,
        closedLabel: String,
    };

    connect() {
        // Set initial button text based on current state
        this.updateButtonState();
    }

    toggle() {
        this.detailsTarget.open = !this.detailsTarget.open;
        this.updateButtonState();
    }

    updateButtonState() {
        const isOpen = this.detailsTarget.open;
        
        // Update button text
        this.buttonTarget.textContent = isOpen
            ? this.openLabelValue
            : this.closedLabelValue;
        
        // Set accessibility and state attributes
        this.buttonTarget.setAttribute('aria-expanded', isOpen);
        this.buttonTarget.setAttribute('data-state', isOpen ? 'open' : 'closed');
    }
}
