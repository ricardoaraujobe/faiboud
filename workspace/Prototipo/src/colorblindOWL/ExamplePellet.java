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
public class ExamplePellet {

	
	private static OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
		
		String url = "file:///E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_RJA_v6.owl";
		String classOWL = "Color";
		String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/colorblindOWL/export_list_individual_java.json";
		String propertyOWL = "colorCode";
		String newIndividual = "color01KKKKKKKKK";
		
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
		//OWLDataProperty colorCode = factory.getOWLDataProperty(propertyOWL, pm);
		
		/**for (OWLNamedIndividual color : reasoner.getInstances(colorClass, false).getFlattened()){
			Set <OWLLiteral> codigo = reasoner.getDataPropertyValues(color, colorCode);
			OWLLiteral codigoLit = (OWLLiteral) codigo.toArray()[0];
			System.out.println("Color: "+ renderer.render(color)+ " e "+codigoLit.getLiteral());
		}**/
		OWLClass actionClass = factory.getOWLClass(":Action", pm);
		for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
			System.out.print("Original Color: "+ renderer.render(action));
			
			OWLNamedIndividual originalColor = factory.getOWLNamedIndividual(":"+renderer.render(action), pm);
			OWLDataProperty colorCode = factory.getOWLDataProperty(":colorCode", pm);
			OWLObjectProperty isOriginalColor = factory.getOWLObjectProperty(":isOriginalColor", pm); 
			for (OWLLiteral code : reasoner.getDataPropertyValues(originalColor, colorCode)) { 
	            System.out.println(" - Color code: " + code.getLiteral()); 
	            
	            for (OWLNamedIndividual ind : reasoner.getObjectPropertyValues(originalColor, isOriginalColor).getFlattened()) { 
	                
	            	
	            	
	            	System.out.print(" - Color: " + renderer.render(ind)); 
	            	OWLNamedIndividual adaptedColor = factory.getOWLNamedIndividual(":"+renderer.render(ind), pm);
	            	OWLDataProperty adaptedColorCode = factory.getOWLDataProperty(":colorCode", pm);
	            	for (OWLLiteral adaptedCode : reasoner.getDataPropertyValues(adaptedColor, adaptedColorCode)) { 
	            		System.out.println(" - Color code: " + adaptedCode.getLiteral());
	            	}
	            	
	            	
	            }
	            
	        } 
			
			
		
		}
		
		
		/**OWLNamedIndividual martin = factory.getOWLNamedIndividual(":RF8F783_Deut", pm); 
		 
        //get values of selected properties on the individual 
        OWLDataProperty hasEmailProperty = factory.getOWLDataProperty(":colorCode", pm); 
 
        OWLObjectProperty isEmployedAtProperty = factory.getOWLObjectProperty(":hasOriginalColor", pm); 
 
        for (OWLLiteral email : reasoner.getDataPropertyValues(martin, hasEmailProperty)) { 
            System.out.println("Martin has email: " + email.getLiteral()); 
        } 
	
        for (OWLNamedIndividual ind : reasoner.getObjectPropertyValues(martin, isEmployedAtProperty).getFlattened()) { 
            System.out.println("Martin is employed at: " + renderer.render(ind)); 
        } **/
        
        
	
	}
	
	
}
