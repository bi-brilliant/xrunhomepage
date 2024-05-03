class ImageUploadAdapter {
	constructor(loader) {
		this.loader = loader;
	}

	upload() {
		return this.loader.file.then(
			(file) =>
				new Promise((resolve, reject) => {
					this._initRequest();
					this._initListeners(resolve, reject, file);
					this._sendRequest(file);
				})
		);
	}

	abort() {
		if (this.xhr) {
			this.xhr.abort();
		}
	}

	_initRequest() {
		const xhr = (this.xhr = new XMLHttpRequest());
		xhr.open('POST', process.env.ControllerUploadImage, true);
		xhr.responseType = 'json';
	}

	_initListeners() {
		const xhr = this.xhr,
			loader = this.loader,
			genericErrorText = `Couldn't upload file: ${file.name}`;

		xhr.addEventListener('error', () => reject(genericErrorText));
		xhr.addEventListener('abort', () => reject());
		xhr.addEventListener('load', () => {
			const response = xhr.response;

			if (!response || response.error) {
				return reject(response && response.error ? response.error.message : genericErrorText);
			}

			resolve({
				default: response.url,
			});
		});

		if (xhr.upload) {
			xhr.upload.addEventListener('progress', (evt) => {
				if (evt.lengthComputable) {
					loader.uploadTotal = evt.total;
					loader.uploaded = evt.loaded;
				}
			});
		}
	}

	_sendRequest(file) {
		const data = new FormData();
		data.append('upload', file);

		console.log(data);

		this.xhr.send(data);
	}
}
