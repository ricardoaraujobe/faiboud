package colorblind;

import java.io.FileWriter;
import java.util.Collection;
import java.util.Collections;
import java.util.Iterator;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLClassAssertionAxiom;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLDataPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLIndividual;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLObjectPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.search.EntitySearcher;
import org.semanticweb.owlapi.util.OWLEntityRemover;
import org.semanticweb.owlapi.model.OWLLiteral;

public class RemovePreference{

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
	   
           
           
           //String url = "file:////E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_preenchida_v1.owl";
		String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";
   		//variaveis
   		String classOWL = "UserPreferences";
   		String individualOWL = args[0];
   		String color = args[1];
   		
   		
   		




   		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory(); //carrega fabrica de classes, axiomas, etc.
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
		//pm.setDefaultPrefix(IRI_BASE+"#");

		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		OWLNamedIndividual adaptedColor = factory.getOWLNamedIndividual(":"+color, pm);
		OWLNamedIndividual user = factory.getOWLNamedIndividual(":"+individualOWL, pm);
		OWLObjectProperty hasPreferedColorChange = factory.getOWLObjectProperty(":hasPreferedColorChange",pm);
		OWLObjectPropertyAssertionAxiom propertyAssertion = factory.getOWLObjectPropertyAssertionAxiom(hasPreferedColorChange, user, adaptedColor);
		//OWLClassAssertionAxiom classAssertion = factory.getOWLClassAssertionAxiom(cls, adaptedColor);
		manager.removeAxiom(Ontology, propertyAssertion);
		manager.saveOntology(Ontology);

		//System.out.println(propertyAssertion);
		
	}
}
