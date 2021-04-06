SVGFILES := $(wildcard *.svg)
MINSVGS := $(SVGFILES:%.svg=min/%.svg)

all: $(MINSVGS)

min/%.svg : %.svg
	svgo -i $*.svg -o min/$*.svg

clean:
	rm $(MINSVGS)
