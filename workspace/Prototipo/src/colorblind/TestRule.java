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
import org.semanticweb.owlapi.model.OWLObjectProperty;
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

public class TestRule
{
  @SuppressWarnings("unchecked")
public static void main(String[] args) throws OWLOntologyCreationException, SWRLParseException, SWRLBuiltInException, OWLOntologyStorageException, IOException, InterruptedException
  {
    
	  
	  String pathology = "Deuteranopia";
	  String context = "Maps";
	  String user = "ricardo.araujo";
	  String result = "DeutMapsRule";
	 

	  String url = "file:///E:/tmp/ColorBlindOntology.owl";
		String classOWL = "Color";
		String urlExportJSON ="E:/tmp/11111_teste.json";
		
		
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
		for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
			System.out.print("Original Color: "+ renderer.render(action));
			obj.put("color", list_color);
			
			
			
			
			OWLNamedIndividual originalColor = factory.getOWLNamedIndividual(":"+renderer.render(action), pm);
			OWLDataProperty colorCode = factory.getOWLDataProperty(":colorCode", pm);
			
			
			//OWLObjectProperty isOriginalColor = factory.getOWLObjectProperty(":isOriginalColor", pm); 
			
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