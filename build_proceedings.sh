#!/bin/bash

conference=ICCBR
year=2015

# prepare target folder
rm -rf target
mkdir target
mkdir target/$conference$year
TARGET=target/$conference$year
rm -rf frontmatter
mkdir frontmatter

# copy assets into proper places
cp assets/ceurws-bg.png target
cp assets/ceurws-bullet-6x12.png target
cp assets/ceur-ws.css target
cp assets/CEUR-WS-logo-blue.png target
cp assets/CEUR-WS-logo.png target
cp assets/llncs.cls frontmatter
cp assets/nopageno.sty frontmatter
cp assets/logo.png frontmatter
cp assets/logo.png $TARGET

# compile front matter (page numbers will be incorrect - redo at end)
php templates/frontmatter-template.php > frontmatter/frontmatter.tex
cd frontmatter
echo "entering $(pwd)"
pdflatex frontmatter
cd ..
echo "backing up to $(pwd)"
currentpage=$((1 + $(cpdf -pages frontmatter/frontmatter.pdf)))

all_workshops=""
current_paper=1

# generate proceedings for each workshop
cd workshops;
echo "entering $(pwd)"
for workshop in *; do
  cd $workshop; 
  echo "entering $(pwd)"

  all_papers=""
  cpdf -add-text "%Bates" -bates $currentpage -topright 50 frontmatter/preface.pdf -o ../../$TARGET/$workshop\_preface.pdf
  currentpage=$(($currentpage + $(cpdf -pages frontmatter/preface.pdf)))
  if (((1 + $currentpage) % 2)); then  # start next page on an odd page
    currentpage=$(($currentpage + 1)); 
    all_papers="$all_papers ../assets/blank.pdf"
  fi 

  
  # stamp all papers w/ copyright and page numbers
  cd papers
  echo "entering $(pwd)"
  for paper in *; do
    echo "stamping page $currentpage..."
    cpdf -stamp-on ../../../assets/copyright-footer.pdf $paper/paper.pdf 1 AND -add-text "%Bates" -bates $currentpage -topright 50 -o ../../../$TARGET/paper$current_paper.pdf
    all_papers="$all_papers ../$TARGET/paper$current_paper.pdf"
    currentpage=$(($currentpage + $(cpdf -pages $paper/paper.pdf)))
    current_paper=$(($current_paper + 1));
  done 

  cd ../..
  echo "backing up to $(pwd)"

  cpdf ../$TARGET/$workshop\_preface.pdf $all_papers -o ../$TARGET/$workshop\_proc.pdf

  all_workshops="$all_workshops $TARGET/${workshop}_proc.pdf"
done
cd ..
echo "backing up to $(pwd)"

# rebuild tables of contents with correct page numbers
php templates/frontmatter-template.php > frontmatter/frontmatter.tex
cd frontmatter
pdflatex frontmatter
cd ..
cp frontmatter/frontmatter.pdf $TARGET
php templates/index-template.php > $TARGET/index.html

cpdf frontmatter/frontmatter.pdf $all_workshops -o $TARGET/$conference$year\_workshop_proceedings.pdf
