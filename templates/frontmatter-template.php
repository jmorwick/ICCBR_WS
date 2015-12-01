<?php
require('config/template-config.php');
require('templates/template-common.php');
?>\documentclass{llncs}
\usepackage{longtable}
\usepackage{graphicx}
\usepackage{nopageno}
\newcommand{\tocTitle}[2]{\protect\contentsline{title}{#1}{#2}}
\newcommand{\tocAuthors}[1]{{\raggedright \leftskip 15pt \rightskip 2.55em\itshape #1\endgraf}}
\newcommand{\tocSection}[1]{\subsection*{#1}}
\pagestyle{plain}
\pagenumbering{roman}
\begin{document}
\setcounter{page}{1}

\begin{center}
\textbf{{\Huge <?=$acronym?> <?=$year?>}} 
\begin{figure}[ht!]
\centering
\includegraphics[width=5in]{logo.png}
\end{figure}

{\Large <?=$city?>, <?=$country?> \hspace{1in} <?=$days?> <?=$month_name?> <?=$year?>}
\vfill
\textbf{{\Large <?=$full_conference_title?> \\
(<?=$acronym?> <?=$year?>)}} \\
\vfill
\textbf{{\LARGE Workshop Proceedings}} \\
\vfill
{\large <?=format_names_with_and($editors)?> (Editor<?=count($editors)>1?'s':''?>)}
\end{center}

\vfill                         
\vfill

\clearpage


\mbox{}
\clearpage

\section*{Preface}
<?=file_get_contents('assets/preface.tex')?>
~\bigskip


\noindent
\begin{minipage}[t]{.4\textwidth}
<?=$month_name?> <?=$year?>\\
<?=$city?>
\end{minipage}%
\hfill
\begin{minipage}[t]{.4\textwidth}\flushright
<?=format_names($editors)?> \\ (Workshop Chair<?=count($editors)>1?'s':''?>)
\end{minipage}

\clearpage

\mbox{}
\clearpage

<?php $current_page = pdf_length('frontmatter/frontmatter.pdf'); ?>

\section*{Table of Contents}
<?php foreach($workshops as $workshop) { ?>
\bigskip
\subsection*{<?=$workshop['title']?>}
  \tocTitle{Preface}{<?=$current_page + ($current_page % 2 == 0 ? 3 : 2)?>}
  \tocAuthors{<?=format_names($workshop['editors'])?>}
<?php 
$current_page += ($current_page % 2 == 0 ? 1 : 0) + pdf_length('workshops/'.$workshop['shortname'].'/frontmatter/preface-stamped.pdf');
foreach($workshop['papers'] as $paper) { ?>
  \tocTitle{<?=$paper['title']?>}{<?=$current_page?>}
  \tocAuthors{<?=format_names($paper['authors'])?>}
<?php 
	$current_paper++;
	$current_page += $paper['length'];

} ?>
<?php } ?>

\end{document}
