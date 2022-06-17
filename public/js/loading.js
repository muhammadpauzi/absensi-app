export const setLoadingButton = (buttonElement, state = true) => {
    if (state) {
        const initialText = buttonElement.textContent;
        buttonElement.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span><span id="initial-text">${initialText}</span>`;
        return buttonElement.setAttribute("disabled", true);
    }

    const initialText =
        buttonElement.querySelector("#initial-text").textContent;
    buttonElement.innerHTML = initialText;
    return buttonElement.removeAttribute("disabled");
};
