package colorblind;

//import java.io.File;
import java.io.FileWriter;
import java.io.IOException;


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
//import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyCreationException;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.OWLOntologyStorageException;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.reasoner.OWLReasoner;
import org.semanticweb.owlapi.reasoner.OWLReasonerFactory;
//import org.swrlapi.factory.SWRLAPIFactory;
import org.swrlapi.parser.SWRLParseException;
//import org.swrlapi.sqwrl.SQWRLQueryEngine;
//import org.swrlapi.sqwrl.SQWRLResult;
//import org.swrlapi.sqwrl.exceptions.SQWRLException;

import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;

//import org.swrlapi.core.SWRLAPIRule;
//import org.swrlapi.core.SWRLRuleEngine;
//import org.swrlapi.drools.*;
import org.swrlapi.exceptions.SWRLBuiltInException;

public class Teste
{
  @SuppressWarnings("unchecked")
public static void main(String[] args) throws OWLOntologyCreationException, SWRLParseException, SWRLBuiltInException, OWLOntologyStorageException, IOException, InterruptedException
  {
    
	  
	 String pathology = args[0];
	  String context = args[1];
	  String user = args[2];
	  String result = args[3];
	  
	  
	  
	  
	  
	  
	  
	  
	 
	 /**
	// Create OWLOntology instance using the OWLAPI
	  OWLOntologyManager ontologyManager = OWLManager.createOWLOntologyManager();
	  OWLOntology ontology 
	    = ontologyManager.loadOntologyFromOntologyDocument(new File("/var/www/workspace/Prototipo/src/ColorBlindOntology.owl"));
	  
	  // Create a SWRL rule engine using the SWRLAPI  
	  SWRLRuleEngine ruleEngine = SWRLAPIFactory.createSWRLRuleEngine(ontology);
	  
	
	  // Create a SWRL rule  
	  
   SWRLAPIRule rule = ruleEngine.createSWRLRule(user+"_"+pathology+"_color_rule2","AdaptedColor(?a) ^ Color(?c) ^ "
	  		+ ""+pathology+"(?d) ^ "+context+"(?m) ^ RecoloringAlgorithm(?r) ^ recoloringAlgorithmAdaptedColors(?r,?a) ^ "
	  		+ "algorithmAdaptedColorAccessContext(?m, ?a) ^ "
	  		+ " hasOriginalColor(?a, ?c) ^ isOriginalColor(?c, ?a) ^ pathologyTypeAdaptedColor(?d, ?a) ^ "
	  		+ "recoloringAlgorithmAdaptedColors(?r, ?a) -> "+result+"(?c)");


	  SWRLAPIRule rule2 = ruleEngine.createSWRLRule(user+"_"+pathology+"_color_rule3","PreAdaptedColor(?p) ^ Color(?c) ^ "
		  		+ ""+pathology+"(?d) ^ "+context+"(?m) ^ RecoloringAlgorithm(?r) ^ recoloringAlgorithmAdaptedColors(?r,?p) ^  "
		  		+ "preAdaptedColorAccessContext(?m, ?p) ^ "
		  		+ " hasOriginalColor(?p, ?c) ^ isOriginalColor(?c, ?p) ^ pathologyTypeAdaptedColor(?d, ?p) -> "+result+"(?c)");

   //System.out.println(rule);
	  //System.out.println("Number of axioms: " + ontology.getAxiomCount());
	  // Run the rule engine
	  //ruleEngine.infer();
	 // ruleEngine.run();
	  
	  ontologyManager.saveOntology(ontology);
	  //Thread.sleep(10000);
	         **/
	  String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";
	  //String url = "file:///C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/ColorBlindOntology.owl";
		String classOWL = "Color";
		String urlExportJSON ="/vagrant/www/includes/json/"+user+"_"+context+"export_list_color_java.json";
		System.setSecurityManager(null);
		
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
		@SuppressWarnings("unused")
		OWLClass colorClass = factory.getOWLClass(":"+classOWL, pm);
			
		
		JSONArray list_color = new JSONArray();
		JSONObject obj = new JSONObject();
		FileWriter file = new FileWriter(urlExportJSON);
		
        OWLClass actionClass = factory.getOWLClass(":"+result, pm);
        obj.put("color", list_color);
		for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
			System.out.print("Original Color: "+ renderer.render(action));
			
			
			
			
			OWLNamedIndividual originalColor = factory.getOWLNamedIndividual(":"+renderer.render(action), pm);
			OWLDataProperty colorCode = factory.getOWLDataProperty(":colorCode", pm);
			
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
