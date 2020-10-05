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

public class ExampleListIndividual {

	
	private static OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
		
		String url = "file:///E:/mestrado/pesquisa/2016/Ontologias/ColorBlindOntology_RJA_v5.owl";
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
	

		
		//carrega uma classe
		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		System.out.println("Ontologia: " + cls.getIRI()); //imprime na tela a URI da ontologia
		
		//retorna os indivíduos da classe
		Collection<OWLIndividual> individual = EntitySearcher.getIndividuals(cls, Ontology);
		System.out.println("Quantidade de individuos: " + individual.size());//imprime a quantidade de individuos da classe
		
		//imprime os indivíduos na tela e exporta para arquivo JSON
		Iterator<OWLIndividual> idindividual = individual.iterator();
		//OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		
		
		
		JSONArray list = new JSONArray();
		JSONObject obj = new JSONObject();
		obj.put("color", list);
		
		while (idindividual.hasNext()){
			OWLIndividual ind = idindividual.next();
			
			
			
			
			
			
			FileWriter file = new FileWriter(urlExportJSON);
			
			
					
			
			
			String individualOWL=renderer.render(ind);
			
			
			
			
			
			//lista propriedade de um individuo
			OWLIndividual idv = factory.getOWLNamedIndividual(":"+individualOWL, pm);
			OWLDataProperty dtPr = factory.getOWLDataProperty(IRI.create(pm.getDefaultPrefix() + propertyOWL));
			Collection<OWLLiteral> valueDtPr = EntitySearcher.getDataPropertyValues(idv, dtPr, Ontology);
			Iterator<OWLLiteral> idDtPr = valueDtPr.iterator();
			while (idDtPr.hasNext()){
				OWLLiteral dp = idDtPr.next();
				
				
				list.add(dp.getLiteral());
				 
				file.write(obj.toJSONString());
				file.flush();
				
				file.close();
				
				
				System.out.println("A propriedade "+ propertyOWL+" de " + renderer.render(idv)+ " e: " + dp.getLiteral());
				
			}
			
			
		}
		/**OWLNamedIndividual newInd = factory.getOWLNamedIndividual(":"+newIndividual, pm);
		OWLClassAssertionAxiom classAssertion = factory.getOWLClassAssertionAxiom(cls, newInd);
		manager.addAxiom(Ontology, classAssertion);
		manager.saveOntology(Ontology);
		System.out.println(newIndividual+" inserido em "+classOWL);**/
		
		
	}
	
	
}
