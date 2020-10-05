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


public class AdaptedColor {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
	       
           
           
		String url = "file:////var/www/workspace/Prototipo/src/ColorBlindOntology_teste_v4.ow";
   		
   		//variaveis
   		String classOWL = "AdaptedColor";
   		String newClassOWL = "User";
   		//String individualOWL =  "ricardo.araujo";
   		String individualOWL =  "RC6AD74";
   		String propertyOWL = "colorCode";
   		String objectPropertyOWL = "hasPathologyType";
   		String newIndividual = "Ricardo_002";
   		String newObjectIndividual = "BBBBBB";
   		String newDataProperty = "AAAAAA";
   		
		String urlExportJSON ="/var/www/html/includes/export_list_Adapted_color_java.json";

   		
   		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory();
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
        //pm.setDefaultPrefix(IRI_BASE+"#");
		
		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		System.out.println("Ontologia: " + cls.getIRI());
		Collection<OWLIndividual> individual = EntitySearcher.getIndividuals(cls, Ontology);
		System.out.println("Quantidade de individuos: " + individual.size());
		
		Iterator<OWLIndividual> idindividual = individual.iterator();		
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		
		JSONArray list_color = new JSONArray();
		JSONObject obj = new JSONObject();
		FileWriter file = new FileWriter(urlExportJSON);
		
		while(idindividual.hasNext()){
			OWLIndividual idv = idindividual.next();
			OWLDataProperty colorCode = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix()+"colorCode"));
			Collection<OWLLiteral> valueColorCode = EntitySearcher.getDataPropertyValues(idv, colorCode, Ontology);
			Iterator<OWLLiteral> idColorCode = valueColorCode.iterator();
			
			while(idColorCode.hasNext()){
				OWLLiteral code = idColorCode.next();
				OWLObjectProperty hasOriginalColor = factory.getOWLObjectProperty(":hasOriginalColor", pm);
				Collection<OWLIndividual> originalColor = EntitySearcher.getObjectPropertyValues(idv, hasOriginalColor, Ontology);
				Iterator<OWLIndividual> idOriginalColor = originalColor.iterator();
				
				
				
				
				while(idOriginalColor.hasNext()){
					OWLIndividual orColor = idOriginalColor.next();
					OWLDataProperty colorCodeOriginal = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix()+"colorCode"));
					Collection<OWLLiteral> valueColorCodeOriginal = EntitySearcher.getDataPropertyValues(orColor, colorCodeOriginal, Ontology);
					Iterator<OWLLiteral> idColorCodeOriginal = valueColorCodeOriginal.iterator();
					while(idColorCodeOriginal.hasNext()){
						OWLLiteral codeOriginal = idColorCodeOriginal.next();
					
						if (renderer.render(orColor).equals(individualOWL)) {  
							
							obj.put("color", list_color);
							list_color.add(renderer.render(idv)+"-"+code.getLiteral());
							System.out.println("Color: " + renderer.render(idv)+" Code: "+code.getLiteral()+" Cor original: " + renderer.render(orColor)+" Code original: "+codeOriginal.getLiteral()+" Ref:"+ individualOWL);
				        } 
					//System.out.println("Color: " + renderer.render(idv)+" Code: "+code.getLiteral()+" Cor original: " + renderer.render(orColor)+" Code original: "+codeOriginal.getLiteral()+" Ref:"+ individualOWL);
			}
				}
					
			}
			
			
			
		}
		
		
		file.write(obj.toJSONString());
		file.flush();
		file.close();
		
		
		
		/**OWLIndividual idv = factory.getOWLNamedIndividual(":"+individualOWL, pm);
		OWLDataProperty dtPr = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix() + propertyOWL));
		Collection<OWLLiteral> valueDtPr = EntitySearcher.getDataPropertyValues(idv, dtPr, Ontology);
		Iterator<OWLLiteral> idDtPr = valueDtPr.iterator();
		while (idDtPr.hasNext()){
			OWLLiteral dp = idDtPr.next();
			
			
			
			
			
			System.out.println("O valor de " + renderer.render(idv)+ " e: " + dp.getLiteral());
			
		}**/
		
		
		
		
		
		
		
		
		
		
		
	}

	
	
	
	
	
	
	
	

}


