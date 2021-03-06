

# ICCBR_WS
ICCBR Workshop proceedings build script for CEUR

Note: this project has been archived. Remaining issues won't be attended to in this repository. As it has been a number of years since this script was used, CEUR standards have likely changed. Feel free to use this code as a starting point if you are intending to develop your own script. 

The original readme is below

To prepare the script:
* you will need a UNIX/BASH compatible environment to work within
* download and install [cpdf](http://community.coherentpdf.com/) -- binaries are [here](https://github.com/coherentgraphics/cpdf-binaries)
* clone this git repository
* update the following in the assets folder:
 * preface.tex - the body of the preface to the edited collection
 * logo.png - displayed across the front page of the proceedings and the CEUR web archive
 * copywright-footer.pdf - at the very least, update the year in this. Each paper will have its front-page stamped at the bottom with this notice.
* update all variables in config/template-config.php
* update the two variables at the top of build_proceedings.sh
* create a directory called workshops
* within the workshops directory, create subdirectories for each workshop. use short names with no spaces
* within each workshop directory:
 * create a file called title.txt with the plain-text title of the paper
 * create a file called authors.txt with latex-formatted names of each author, one per line, no commas, in order
 * create a subdirectory called frontmatter which contains a file called frontmatter.pdf, consisting of 3-4 pages (title page, organizers page, and 1-2 pages for the preface). 
 * create a directory called papers with a subdirectory for each paper. Within each of these subdirectories:
   * Make sure the subdirectory names are globally unique (I recommend using "paperXX")
    * create a file called title.txt with the plain-text title of the paper
    * create a file called authors.txt with latex-formatted names of each author, one per line, no commas, in order
    * create a file called paper.pdf with the camera-ready paper for the proceedings with no page numbers or copyright footer

Once you've completed these preparations, you can build the CEUR proceedings and the PDF proceedings by running the build_proceedings.sh script. Please make sure to check the results very carefully! CEUR recommends making the proceedings available on the web for authors to check before the final submission. 

Also note that there are no validation for settings in this script and some issues are not fully resolved. Check the issues listed in this github project and make sure they aren't presenting a problem. 

