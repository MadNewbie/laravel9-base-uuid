document.addEventListener('DOMContentLoaded', (event) => {
    methods.initPreviewImage()
})

const methods = {
    initPreviewImage() {
        const elImageForm = document.getElementsByName('photo_raw')[0];
        const elTruePhoto = document.getElementById('true_photo');
        const elPreviews = document.getElementsByClassName('preview');
        elImageForm.addEventListener('change', (e) => {
            if(e.target.files){
                const file = e.target.files[0];
                let reader = new FileReader();
                reader.onload = (e) => {
                    let img = document.createElement("img");
                    img.onload = (e) => {
                        let canvas = document.createElement("canvas");
                        let ctx = canvas.getContext("2d");
                        canvas.width = 300;
                        canvas.height = 300;

                        const MAX_WIDTH = 300;
                        const MAX_HEIGHT = 300;

                        let width = img.width;
                        let height = img.height;

                        if(width > height){
                            if(width > MAX_WIDTH){
                                height = height * (MAX_WIDTH / width);
                                width = MAX_WIDTH;
                            }
                        } else {
                            if (height > MAX_HEIGHT) {
                                width = width * (MAX_HEIGHT / height);
                                height = MAX_HEIGHT;
                            }
                        }

                        ctx.drawImage(img, 0, 0, 300, 300);
                        let dataUrl = canvas.toDataURL(file.type);
                        elTruePhoto.value = dataUrl;
                        for (const elPreview of elPreviews) {
                            elPreview.src = dataUrl;
                            elPreview.style.display = "block";
                        }
                    }
                    img.src = e.target.result
                }
                reader.readAsDataURL(file);
            }else{
                elPreview.style.display = "none";
            }
        });
    }
}