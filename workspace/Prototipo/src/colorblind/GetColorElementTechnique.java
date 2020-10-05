package colorblind;

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
import org.swrlapi.exceptions.SWRLBuiltInException;
import org.swrlapi.parser.SWRLParseException;
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
import org.semanticweb.owlapi.model.OWLOntologyCreationException;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.OWLOntologyStorageException;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.search.EntitySearcher;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;

@SuppressWarnings("unused")

public class GetColorElementTechnique {
	
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws OWLOntologyCreationException, SWRLParseException, SWRLBuiltInException, OWLOntologyStorageException, IOException, InterruptedException
	  {
	       
		 /**String pathology = "Deut";
		  String context = "Form";
		  String user = "ricardo.araujo";
		  String result = "DeutFormkuhn2008";**/
		
		String pathology =args[0];
		  String context = args[1];
		  String user = args[2];
		  String result =args[3];
           
		  String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";
		  //String url = "file:///C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/ColorBlindOntology.owl";
		  String urlExportJSON ="/vagrant/www/includes/json/element_"+context+"_"+user+"_export_list_Adapted_color_java.json";
		  //String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/element_"+context+"_"+user+"_export_list_Adapted_color_java.json";
		  
		 OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
			IRI iri = IRI.create(url);
			String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
			OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
			OWLDataFactory factory = manager.getOWLDataFactory();
			PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
			
			OWLReasonerFactory reasonerFactory = PelletReasonerFactory.getInstance();
			OWLReasoner reasoner = reasonerFactory.createReasoner(Ontology);
		
			OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		 
			
			JSONArray list_color = new JSONArray();
			JSONObject obj = new JSONObject();
			FileWriter file = new FileWriter(urlExportJSON);
			
			
			OWLClass actionClass = factory.getOWLClass(":"+result, pm);
			
			System.out.println("Color: "+actionClass);
			for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
				
				OWLObjectProperty hasOriginalColor = factory.getOWLObjectProperty(":hasOriginalColor", pm);
				Collection<OWLIndividual> originalColor = EntitySearcher.getObjectPropertyValues(action, hasOriginalColor, Ontology);
				Iterator<OWLIndividual> idOriginalColor = originalColor.iterator();
				idOriginalColor.hasNext();
				OWLIndividual orColor = idOriginalColor.next();
				System.out.println("Color: "+ renderer.render(action)+" Cor original: " + renderer.render(orColor));
			
				obj.put("color", list_color);
				list_color.add(renderer.render(action)+"-"+renderer.render(orColor));
				
			}
			file.write(obj.toJSONString());
			file.flush();
			file.close();
		 
	}

}
