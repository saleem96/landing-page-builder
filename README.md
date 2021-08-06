Code landing page and block rules
General:
Use boostrap 4's default gallery and fontawesome 5.15
Separate CSS is not code in HTML tags
Image:
Do not use background image and overlay
#Landing page

Use the section id when setting the background
#id {
background: url (## image_url ## pexels-kaboompics-com-6224.jpg) rgba (0, 0, 0, .7);
background-size: cover;
background-blend-mode: multiply
}
#Blocks
Use style = "background ..." directly on the div tag;
Don't use for background image: position: relative;

Image path

#Template: ## image_url ## yourimage.png => use image to upload file to public / images / content_media
#Blocks: ## image_url ## yourimage.png => use image to upload file to public / images / content_media

Border top left, bottom, right element not avalible
Don't use imporntat for css. User can't change in builder
Icon:
Use font-awesome 4.7
Do not use class fa-2x fa-3x (To increase size). Increase the size with CSS

Bacgkound color CSS:
only 1 class
.fago-header {
background-color: #FFFFFF;
}
ot
header.fago-header {
background-color: #FFFFFF;
}
