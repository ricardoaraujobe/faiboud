package colorblind;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Collection;
import java.util.Iterator;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLIndividual;
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
import org.semanticweb.owlapi.search.EntitySearcher;
import org.swrlapi.factory.SWRLAPIFactory;
import org.swrlapi.parser.SWRLParseException;
//import org.swrlapi.sqwrl.SQWRLQueryEngine;
//import org.swrlapi.sqwrl.SQWRLResult;
//import org.swrlapi.sqwrl.exceptions.SQWRLException;

import com.clarkparsia.pellet.owlapiv3.PelletReasonerFactory;

import org.swrlapi.core.SWRLAPIRule;
import org.swrlapi.core.SWRLRuleEngine;
//import org.swrlapi.drools.*;
import org.swrlapi.exceptions.SWRLBuiltInException;

@SuppressWarnings("unused")
public class GetAdaptedColor {
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws OWLOntologyCreationException, SWRLParseException, SWRLBuiltInException, OWLOntologyStorageException, IOException, InterruptedException
	  {
		
		
		
		String original = args[0];//"RFE0000";
		String user = args[1];// "ricardo.araujo";
		String result =args[2];//"Teste";
		
		//String url = "file:///C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/teste/ColorBlindOntology.owl";
		String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology.owl";

		String urlExportJSON ="/vagrant/www/includes/json/"+original+"_"+user+"_export_list_Adapted_color_java.json";
		//String urlExportJSON ="C:/HashiCorp/Vagrant/dev/workspace/Prototipo/src/teste/"+original+"_"+user+"_export_list_Adapted_color_java.json";
		
		
		 OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
			IRI iri = IRI.create(url);
			String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
			OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
			OWLDataFactory factory = manager.getOWLDataFactory();
			PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
			
			OWLReasonerFactory reasonerFactory = PelletReasonerFactory.getInstance();
			OWLReasoner reasoner = reasonerFactory.createReasoner(Ontology);
		
			OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		 
			
			
			
			
			OWLClass actionClass = factory.getOWLClass(":"+result, pm);
			
			JSONArray list_color = new JSONArray();
			JSONObject obj = new JSONObject();
			FileWriter file = new FileWriter(urlExportJSON);
			
			System.out.println("Color: "+actionClass);
			for (OWLNamedIndividual action : reasoner.getInstances(actionClass, false).getFlattened()){
				
				OWLObjectProperty hasOriginalColor = factory.getOWLObjectProperty(":hasOriginalColor", pm);
				Collection<OWLIndividual> originalColor = EntitySearcher.getObjectPropertyValues(action, hasOriginalColor, Ontology);
				Iterator<OWLIndividual> idOriginalColor = originalColor.iterator();
				while(idOriginalColor.hasNext()){
					OWLIndividual orColor = idOriginalColor.next();
					OWLDataProperty colorCode = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix()+"colorCode"));
					Collection<OWLLiteral> valueColorCode = EntitySearcher.getDataPropertyValues(action, colorCode, Ontology);
					Iterator<OWLLiteral> idColorCode = valueColorCode.iterator();
					OWLLiteral code = idColorCode.next();
					
					
					
					if (renderer.render(orColor).equals(original)) {
						
						obj.put("color", list_color);
						list_color.add(renderer.render(action)+"-"+code.getLiteral());
				System.out.println("Color: "+ renderer.render(action)+" Cor original: " +code.getLiteral());
					}
					
				
				}
				
			}
		
			file.write(obj.toJSONString());
			file.flush();
			file.close();
	}

}
