export function asset(file) {
    // Get the current URL
    let currentUrl = window.location.href;

    // Find the last occurrence of '/public'
    let publicIndex = currentUrl.lastIndexOf('/public');

    // If '/public' is found in the URL
    if (publicIndex !== -1) {
        // Construct the base URL up to '/public'
        let baseUrl = currentUrl.substring(0, publicIndex+7); // 7 characters in "/public"

        console.log("We Are Using The Last '/public' directory.");

        // Concatenate the file path
        return baseUrl + '/' + file;
    } else {
        // Handle the case where '/public' is not found
        return '/' + file;
    }
}

// Function to get the value of a specific cookie
export function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift(); else return 'ar';
}



export function createMediaElement(mediaUrl, id, alt = 'question', classAttr=null) {
    const extension = mediaUrl.split('.').pop().toLowerCase();
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    const videoExtensions = ['mp4', 'avi', 'mov'];
    const audioExtensions = ['mp3', 'wav', 'ogg'];

    let mediaElement;

    if (imageExtensions.includes(extension)) {
        mediaElement = $('<img>', {
            id: id,
            src: mediaUrl,
            alt: alt,
            class: classAttr
        });
    } else if (videoExtensions.includes(extension)) {
        mediaElement = $('<video>', {
            id: id,
            controls: true,
            class: classAttr
        }).append(
            $('<source>', {
                src: mediaUrl,
                type: 'video/' + extension
            }),
            'Video format is not supported.'
        );
    } else if (audioExtensions.includes(extension)) {
        mediaElement = $('<audio>', {
            id: id,
            controls: true,
            class: classAttr
        }).append(
            $('<source>', {
                src: mediaUrl,
                type: 'audio/' + extension
            }),
            'Audio format is not supported.'
        );
    } else {
        mediaElement = $('<p>', {
            id: id,
            text: 'Unsupported media type.'
        });
    }

    return mediaElement;
}
