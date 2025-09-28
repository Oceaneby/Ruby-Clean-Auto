document.addEventListener('DOMContentLoaded', function () {
  const typeField = document.querySelector('select[name="Gallery[type]"]');
  const imageFieldWrapper = document.querySelector('.field-image')?.closest('.form-group, .form-row, .col-md-6, .form-field');
  const videoFieldWrapper = document.querySelector('.field-video')?.closest('.form-group, .form-row, .col-md-6, .form-field');
  const imageInput = document.querySelector('input[name="Gallery[imageFile]"]');
  const videoInput = document.querySelector('input[name="Gallery[videoFile]"]');

  function toggleFields() {
    if (!typeField || !imageFieldWrapper || !videoFieldWrapper) return;

    const type = typeField.value;

    if (type === 'photo') {
      imageFieldWrapper.style.display = '';
      videoFieldWrapper.style.display = 'none';
      if (imageInput) imageInput.required = true;
      if (videoInput) videoInput.required = false;
    } else if (type === 'video') {
      imageFieldWrapper.style.display = 'none';
      videoFieldWrapper.style.display = '';
      if (imageInput) imageInput.required = false;
      if (videoInput) videoInput.required = true;
    } else {
      imageFieldWrapper.style.display = 'none';
      videoFieldWrapper.style.display = 'none';
      if (imageInput) imageInput.required = false;
      if (videoInput) videoInput.required = false;
    }
  }

  if (typeField) {
    typeField.addEventListener('change', toggleFields);
    toggleFields(); // initialise au chargement
  }
});