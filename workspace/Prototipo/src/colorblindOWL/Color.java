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
import java.util.Iterator;
import java.util.Set;

import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;

import org.semanticweb.owlapi.reasoner.OWLReasoner; 
import org.semanticweb.owlapi.reasoner.OWLReasonerFactory; 
import org.semanticweb.owlapi.reasoner.SimpleConfiguration; 
import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;
import org.semanticweb.owlapi.vocab.PrefixOWLOntologyFormat;



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
import org.semanticweb.owlapi.search.EntitySearcher;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

@SuppressWarnings("unused")
public class Color {

	
	private static OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
		
		String url = "file:///E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_RJA_v6.owl";
		String classOWL = "Color";
		String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/colorblindOWL/export_list_color_java.json";
		
		
		//carrega a ontologia
	
		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory();
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
		pm.setDefaultPrefix(IRI_BASE+"#");
	

		OWLReasonerFactory reasonerFactory = PelletReasonerFactory.getInstance();
		OWLReasoner reasoner = reasonerFactory.createReasoner(Ontology);
	
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		OWLClass colorClass = factory.getOWLClass(":"+classOWL, pm);
				
		
		JSONArray list_color = new JSONArray();
		JSONObject obj = new JSONObject();
		FileWriter file = new FileWriter(urlExportJSON);
		
		OWLClass actionClass = factory.getOWLClass(":Action", pm);
		for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
			System.out.print("Original Color: "+ renderer.render(action));
			obj.put("color", list_color);
			
			
			
			
			OWLNamedIndividual originalColor = factory.getOWLNamedIndividual(":"+renderer.render(action), pm);
			OWLDataProperty colorCode = factory.getOWLDataProperty(":colorCode", pm);
			OWLObjectProperty isOriginalColor = factory.getOWLObjectProperty(":isOriginalColor", pm); 
			for (OWLLiteral code : reasoner.getDataPropertyValues(originalColor, colorCode)) { 
	            System.out.println(" - Color code: " + code.getLiteral()); 
	            
	    		
	            
	            list_color.add(renderer.render(action)+"-"+code.getLiteral());
            	
            	
				 
	       
				
	            	
	            
	    		
	            
	          
	        } 
			
			
		}
		
		file.write(obj.toJSONString());
		file.flush();
		file.close();
			
		
        
	
	}
	
	
	
	
}
