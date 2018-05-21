#!/bin/sh
for f in **.php; do 
  fn=$(basename "$f") # remove directory name
  Fn=${fn^}           # uppercase first letter
  mv -- "$f" "$(dirname "$f")/$Fn"  # combine both
done