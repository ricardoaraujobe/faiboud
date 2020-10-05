package colorblindOWL;

import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.Writer;
//import com.google.gson.Gson;
//import com.google.gson.GsonBuilder;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;



import java.util.Collection;
import java.util.Collections;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Set;

import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.AddAxiom;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;

import org.semanticweb.owlapi.reasoner.OWLReasoner; 
import org.semanticweb.owlapi.reasoner.OWLReasonerFactory; 
import org.semanticweb.owlapi.reasoner.SimpleConfiguration; 
import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;
import org.semanticweb.owlapi.vocab.PrefixOWLOntologyFormat;
import org.swrlapi.core.SWRLAPIRule;
import org.swrlapi.core.SWRLRuleEngine;
import org.swrlapi.factory.SWRLAPIFactory;
import org.semanticweb.owlapi.util.*;


import java.io.ByteArrayOutputStream;
import java.io.File;
import java.util.*;

import javax.annotation.Nonnull;




import org.semanticweb.owlapi.model.OWLClassAssertionAxiom;
import org.semanticweb.owlapi.model.OWLClassExpression;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLIndividual;
import org.semanticweb.owlapi.model.OWLLiteral;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLObjectPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.model.SWRLAtom;
import org.semanticweb.owlapi.model.SWRLClassAtom;
import org.semanticweb.owlapi.model.SWRLObjectPropertyAtom;
import org.semanticweb.owlapi.model.SWRLRule;
import org.semanticweb.owlapi.model.SWRLVariable;
import org.semanticweb.owlapi.search.EntitySearcher;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

@SuppressWarnings("unused")
public class ExampleSWRL {

	
	private static OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
		
		String url = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		String classOWL = "Color";
		String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/colorblindOWL/export_list_color_java.json";
		
		
		
		// Create OWLOntology instance using the OWLAPI
		 OWLOntologyManager ontologyManager = OWLManager.createOWLOntologyManager();
		 OWLOntology ontology = ontologyManager.loadOntologyFromOntologyDocument(new File("E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_teste_v3.owl"));
		 
		 // Create a SWRL rule engine using the SWRLAPI  
		 SWRLRuleEngine ruleEngine = SWRLAPIFactory.createSWRLRuleEngine(ontology);
		 //SWRLRuleEngine ruleEngine = SWRLAPIFactory.createSWRLRuleEngine(ontology);
		 
		 // Create a SWRL rule  
		 SWRLAPIRule rule = ruleEngine.createSWRLRule("IsAdult-Rule",
		   "AdaptedColor(?a) ^ hasOriginalColor(?a, ?c) ^ Color(?c) -> Action(?c)");
		 
		 // Run the rule engine
		 ruleEngine.infer();
		
		/**OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
        // Let's create an ontology and name it
        // "http://www.co-ode.org/ontologies/testont.owl" We need to set up a
        // mapping which points to a concrete file where the ontology will be
        // stored. (It's good practice to do this even if we don't intend to
        // save the ontology).
        IRI ontologyIRI = IRI.create(url);
        // Create a document IRI which can be resolved to point to where our
        // ontology will be saved.
        IRI documentIRI = IRI.create("file:///E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_teste_v3.owl");
        // Set up a mapping, which maps the ontology to the document IRI
        SimpleIRIMapper mapper = new SimpleIRIMapper(ontologyIRI, documentIRI);
        manager.getIRIMappers().add(mapper);
        // Now create the ontology - we use the ontology IRI (not the physical
        // IRI)
        OWLOntology ontology = manager.createOntology(ontologyIRI);
        OWLDataFactory factory = manager.getOWLDataFactory();
        
        OWLClass clsA = factory.getOWLClass(IRI.create(ontologyIRI + "#AdaptedColor"));
        OWLClass clsB = factory.getOWLClass(IRI.create(ontologyIRI + "#Color"));
        SWRLVariable vara = factory.getSWRLVariable(IRI.create(ontologyIRI + "#a"));
        SWRLVariable varc = factory.getSWRLVariable(IRI.create(ontologyIRI + "#c"));
        SWRLRule rule = factory.getSWRLRule(Collections.singleton(factory.getSWRLClassAtom(clsA, vara)), Collections.singleton(factory
        		.getSWRLClassAtom(clsB, varc)));
		
        manager.applyChange(new AddAxiom(ontology, rule));
        OWLObjectProperty prop = factory.getOWLObjectProperty(IRI.create(ontologyIRI + "#hasOriginalColor"));
        //OWLObjectProperty propB = factory.getOWLObjectProperty(IRI.create(ontologyIRI + "#propB"));
        SWRLObjectPropertyAtom propAtom = factory.getSWRLObjectPropertyAtom(prop, vara, varc);
        //SWRLObjectPropertyAtom propAtom2 = factory.getSWRLObjectPropertyAtom(propB, var, var);
        //Set<SWRLAtom> antecedent = new HashSet<SWRLAtom>();
       // antecedent.add(propAtom);
        //antecedent.add(propAtom2);
        //SWRLRule rule2 = factory.getSWRLRule(antecedent, Collections.singleton(propAtom));
        manager.applyChange(new AddAxiom(ontology, rule));
        // Now save the ontology. The ontology will be saved to the location
        // where we loaded it from, in the default ontology format
        manager.saveOntology(ontology);
        
        /**OWLObjectProperty teacherP= factory.getOWLObjectProperty(IRI
                .create(ontologyIRI + "#hasOriginalColor"));

        SWRLVariable var1 = factory.getSWRLVariable(IRI.create(ontologyIRI
                + "#AdaptedColor"));
        SWRLVariable var2 = factory.getSWRLVariable(IRI.create(ontologyIRI
                + "#Color"));
        SWRLObjectPropertyAtom teacherAtom = factory.getSWRLObjectPropertyAtom(
                teacherP, var1, var2);
        SWRLObjectPropertyAtom propAtom = factory.getSWRLObjectPropertyAtom(teacherP, var1, var2);
        
        Set<SWRLAtom> SWRLatomList= new HashSet<SWRLAtom>();
        SWRLatomList.add(teacherAtom);
        SWRLRule teacherRule = factory.getSWRLRule(SWRLatomList,
                Collections.singleton(propAtom));
        manager.applyChange(new AddAxiom(ontology, teacherRule ));
        manager.saveOntology(ontology);**/
        
		
        
	
        
        
        
	}
	
	
	
	
	
	
}
