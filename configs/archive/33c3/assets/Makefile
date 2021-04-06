SVGFILES := $(wildcard *.svg)
MINSVGS := $(SVGFILES:%.svg=min/%.svg)

all: $(MINSVGS)

min/%.svg : %.svg
	svgo $*.svg min/$*.svg

clean:
	rm $(MINSVGS)
