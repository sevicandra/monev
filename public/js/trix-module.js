import {
    Application,
    Controller
} from 'https://cdn.skypack.dev/@hotwired/stimulus'
[...document.querySelectorAll('[js-cloak]')].forEach(el => el.removeAttribute('js-cloak'))
window.Stimulus = Application.start()
class UploadManager {
    #attachments = []

    addAttachment(attachment) {
        this.#attachments.push(attachment)
    }

    removeAttachment(attachment) {
        this.#attachments = this.#attachments.filter(a => a !== attachment)
    }

    removeAttachments() {
        this.#attachments = []
    }

    uploadAttachments() {
        const promises = this.#attachments.map(attachment => this.#uploadAttachment(attachment))
        return Promise.all(promises)
    }

    #uploadAttachment(attachment) {
        const form = new FormData()
        form.append('attachment', attachment.file)

        const options = {
            method: 'POST',
            body: form,
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
            }
        }

        return fetch('/note-attachments', options)
            .then(resp => {
                if (!resp.ok) {
                    throw new Error(`Upload failed: ${resp.statusText}`)
                }
                return resp.json()
            })
            .then((data) => {
                attachment.setAttributes({
                    url: data.image_url,
                    href: data.image_url,
                })
            })
            .catch(error => {
                console.error("Error during upload:", error) // Error logging
            })
    }
}
Stimulus.register("rich-text-uploader", class extends Controller {
    static values = {
        acceptFiles: Boolean
    }

    #uploader

    connect() {
        this.#uploader = new UploadManager()
        const submitButton = document.getElementById('trix-submit-btn');
        const closeButton = document.getElementById('trix-close-btn');
        submitButton.addEventListener('click', () => this.handleSubmit(event));
        closeButton.addEventListener('click', () => this.removeAttachments());
    }

    addAttachment(event) {
        if (!this.acceptFilesValue || !event.attachment.file) return
        this.#uploader.addAttachment(event.attachment)
    }

    removeAttachment(event) {
        this.#uploader.removeAttachment(event.attachment)
    }

    removeAttachments() {
        this.#uploader.removeAttachments()
    }

    handleKeyboardSubmit(event) {

        if (event.key === "Enter" && (event.metaKey || event.ctrlKey)) {
            event.preventDefault()
            this.#uploader.uploadAttachments().then(() => {
                if (this.element.textContent.trim().length > 0) {
                    this.element.closest("form")
                        .requestSubmit()
                }else{
                    alert("Teks tidak boleh kosong")
                }
            }).catch(error => {
                console.error('Error during file upload:', error)
            })
        }
    }
    handleSubmit() {                                
        this.#uploader.uploadAttachments().then(() => {
            if (this.element.textContent.trim().length > 0) {
                this.element.closest("form")
                    .requestSubmit()
            }else{
                alert("Teks tidak boleh kosong")
            }
        }).catch(error => {
            console.error('Error during file upload:', error)
        })
    }


})