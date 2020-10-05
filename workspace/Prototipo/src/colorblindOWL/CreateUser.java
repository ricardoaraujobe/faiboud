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

public class CreateUser{

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
	       //String nome = args[0];


           String url = "file:////var/www/workspace/Prototipo/src/ColorBlindOntology_RJA_v6.owl";

   		//variaveis
   		String classOWL = "User";
   		String newClassOWL = "User";
   		String individualOWL =  "ricardo.araujo";
   		//String individualOWL =  args[0];
   		String propertyOWL = "colorCode";
   		String objectPropertyOWL = "hasPathologyType";
   		String newIndividual = "Ricardo_002";
   		String newObjectIndividual = "BBBBBB";
   		String newDataProperty = "AAAAAA";



     OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory();
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
       // pm.setDefaultPrefix(IRI_BASE+"#");

		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		System.out.println("Ontologia: " + cls.getIRI());
		Collection<OWLIndividual> individual = EntitySearcher.getIndividuals(cls, Ontology);
		System.out.println("Quantidade de individuos: " + individual.size());

		Iterator<OWLIndividual> idindividual = individual.iterator();
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();


		JSONArray list = new JSONArray();
		JSONObject obj = new JSONObject();
		obj.put("users", list);

		while (idindividual.hasNext()){
			OWLIndividual ind = idindividual.next();

			FileWriter file = new FileWriter("/var/www/workspace/Prototipo/src/colorblindOWL/Output.json");

			list.add(renderer.render(ind));


			System.out.println(renderer.render(ind));


			file.write(obj.toJSONString());
			file.flush();

			file.close();

		}











	}









}


