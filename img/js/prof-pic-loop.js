// fetch('../../img/data.json')
//     .then(res => res.json())
//     .then(data => {
//         data.forEach(post => {
//             // Insert post name
//             listEl.insertAdjacentHTML('beforeend', `<p>${post.name}</p>`);

//             // Loop through the post's keys to check for any image properties (img2, img3, img4, etc.)
//             for (let key in post) {
//                 if (key.startsWith('img') && post[key]) {
//                     listEl.insertAdjacentHTML('beforeend', `<img src="${post[key]}">`);
//                 }
//             }
//         });
//     });


document.addEventListener("DOMContentLoaded", function () {
    const timelimit = 8;
    const loop_img_time = timelimit * 1000;

    fetch('../../img/data.json') // Ensure the correct path to your JSON file
        .then(res => res.json())
        .then(data => {
            if (!data || data.length === 0) {
                console.error('No data found in the JSON file.');
                return;
            }

            // Sort the data by 'id' to ensure we start with id=1
            data.sort((a, b) => a.id - b.id);

            const profileImageEl = document.getElementById('profileImage');
            const profileImageEl2 = document.getElementById('profileImage2');
            if (!profileImageEl && !profileImageEl2) {
                console.error('Could not find the image element (#profileImage).');
                return;
            }

            // Function to display images like a GIF with transitions for each post
            function displayImages(post) {
                return new Promise(resolve => {
                    let imageIndex = 1;

                    // Function to update the image source and create the fade effect
                    function updateImage() {
                        if (post[`img${imageIndex}`]) {
                            profileImageEl.src = post[`img${imageIndex}`];
                            profileImageEl.alt = `${post.name} - Image ${imageIndex}`;
                            profileImageEl2.src = post[`img${imageIndex}`];
                            profileImageEl2.alt = `${post.name} - Image ${imageIndex}`;

                            // Fade in the new image
                            profileImageEl.style.transition = 'opacity 1s';
                            profileImageEl.style.opacity = 1;
                            profileImageEl2.style.transition = 'opacity 1s';
                            profileImageEl2.style.opacity = 1;

                            // After 2 seconds (image displayed), fade out the current image
                            setTimeout(() => {
                                profileImageEl.style.opacity = 0;
                                profileImageEl2.style.opacity = 0;
                            }, (loop_img_time - 1000)); // Adjust timing as needed

                            // Move to the next image after 3 seconds (1 second for fade-out)
                            imageIndex++;
                            if (!post[`img${imageIndex}`]) {
                                // Once all images of a post are displayed, resolve the promise to move to the next post
                                clearInterval(imageInterval);
                                resolve(); // Resolve the promise to go to the next post
                            }
                        }
                    }

                    // Update the image every 3 seconds (change image every 3 seconds)
                    const imageInterval = setInterval(updateImage, loop_img_time);
                });
            }

            // Function to cycle through posts with looping
            async function cyclePosts() {
                while (true) { // Infinite loop
                    for (let post of data) {
                        await displayImages(post); // Wait until all images of the current post are displayed
                    }
                }
            }

            // Start cycling through the posts
            cyclePosts();
        })
        .catch(err => {
            console.error('Error fetching data:', err);
        });
});