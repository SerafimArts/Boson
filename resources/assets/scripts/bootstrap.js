window.boson = {
    send: (name, data) => chrome.webview.postMessage({ [name]: data }),
};
