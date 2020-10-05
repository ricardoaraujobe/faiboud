package colorblind;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Optional;

import org.checkerframework.checker.nullness.qual.NonNull;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLLiteral;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyCreationException;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.OWLOntologyStorageException;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.reasoner.OWLReasoner;
import org.semanticweb.owlapi.reasoner.OWLReasonerFactory;
import org.swrlapi.factory.SWRLAPIFactory;
import org.swrlapi.parser.SWRLParseException;
import org.swrlapi.exceptions.SWRLAPIException;

//import org.swrlapi.sqwrl.SQWRLQueryEngine;
//import org.swrlapi.sqwrl.SQWRLResult;
//import org.swrlapi.sqwrl.exceptions.SQWRLException;

import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;

import org.swrlapi.core.SWRLAPIRule;
import org.swrlapi.core.SWRLRuleEngine;
import org.drools.*;
import org.swrlapi.exceptions.SWRLBuiltInException;

@SuppressWarnings("unchecked")

public class CreateCommonRule {

	public static void main(String[] args) throws OWLOntologyCreationException, SWRLParseException, SWRLBuiltInException, OWLOntologyStorageException, IOException, InterruptedException
	  {
     String pathology = args[0];
	  String context = args[1];
	  String user = args[2];
	  String result = args[3];
		
	  
	  /**String pathology = "Deut";
		  String context = "Maps";
		  String user = "ricardo.araujo";
		  String result = "CommonDeutMapsRule";**/
		
		  
	  String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";
	  //String url = "file:///C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/ColorBlindOntology.owl";
		  String urlExportJSON ="/vagrant/www/includes/json/"+user+"_"+context+"_common_preferences.json";
		  //String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/teste/"+user+"_"+context+"_common_preferences.json";
			
		  OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
			IRI iri = IRI.create(url);
			String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
			OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
			OWLDataFactory factory = manager.getOWLDataFactory();
			PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
			//pm.setDefaultPrefix(IRI_BASE+"#");
			

			OWLReasonerFactory reasonerFactory = PelletReasonerFactory.getInstance();
			OWLReasoner reasoner = reasonerFactory.createReasoner(Ontology);
		
			OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
			
			 OWLClass actionClass = factory.getOWLClass(":"+result, pm);
			 ;
             JSONArray list_pref = new JSONArray();
             JSONObject obj = new JSONObject();
		     FileWriter file = new FileWriter(urlExportJSON);

				for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
					
					System.out.print("Technique: "+ renderer.render(action));

                    obj.put("tech", list_pref);
					list_pref.add(renderer.render(action));
				}
		  
				file.write(obj.toJSONString());
				file.flush();
				file.close();
	  }
}
