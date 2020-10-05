package colorblind;

import java.io.FileWriter;
import java.util.Collection;
import java.util.Iterator;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.semanticweb.owlapi.apibinding.OWLManager;
import org.semanticweb.owlapi.dlsyntax.renderer.DLSyntaxObjectRenderer;
import org.semanticweb.owlapi.io.OWLObjectRenderer;
import org.semanticweb.owlapi.model.IRI;
import org.semanticweb.owlapi.model.OWLClass;
import org.semanticweb.owlapi.model.OWLClassAssertionAxiom;
import org.semanticweb.owlapi.model.OWLDataFactory;
import org.semanticweb.owlapi.model.OWLDataProperty;
import org.semanticweb.owlapi.model.OWLDataPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLIndividual;
import org.semanticweb.owlapi.model.OWLNamedIndividual;
import org.semanticweb.owlapi.model.OWLObjectProperty;
import org.semanticweb.owlapi.model.OWLObjectPropertyAssertionAxiom;
import org.semanticweb.owlapi.model.OWLOntology;
import org.semanticweb.owlapi.model.OWLOntologyManager;
import org.semanticweb.owlapi.model.PrefixManager;
import org.semanticweb.owlapi.search.EntitySearcher;
import org.semanticweb.owlapi.model.OWLLiteral;

public class CreatePreference{

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws Exception {
	       //String nome = args[0];
           
           
           //String url = "file:////vagrant/workspace/Prototipo/src/ColorBlindOntology_teste_v1.owl";
           String url = "file:////var/www/workspace/Prototipo/src/ColorBlindOntology_teste_v4.owl";
   		//variaveis
   		String classOWL = "PreferedColor";
   		String userClassOWL = "User";
   		String individualOWL = args[0];// "ricardo.araujo";
   		String colorName= args[1];//"RD5D53C_Deut_Huang";
   		String colorCode = args[2];//"#RD5D53C";
   		String colorProperty ="hasOriginalColor";
   		String originalColor = args[3];//"R0EED92";
   		String propertyColor = "colorCode";
   		String context = args[4];//"ColoredMaps";
   		String contextProperty ="isInContext";
   		String preferenceProperty = "hasUserPrefences";
   		
   		
   		
   		
   		OWLOntologyManager manager = OWLManager.createOWLOntologyManager();
		IRI iri = IRI.create(url);
		String IRI_BASE = "http://www.semanticweb.org/rbonacin/ontologies/2016/1/untitled-ontology-31";
		OWLOntology Ontology = manager.loadOntologyFromOntologyDocument(iri);
		OWLDataFactory factory = manager.getOWLDataFactory(); //carrega fabrica de classes, axiomas, etc.
		PrefixManager pm = (PrefixManager) manager.getOntologyFormat(Ontology);
		//pm.setDefaultPrefix(IRI_BASE+"#");
		
		OWLClass cls = factory.getOWLClass(":"+classOWL, pm);
		OWLClass clsUser = factory.getOWLClass(":"+userClassOWL, pm);
		System.out.println("Ontologia: " + cls.getIRI());
		Collection<OWLIndividual> individual = EntitySearcher.getIndividuals(cls, Ontology);
		System.out.println("Quantidade de individuos: " + individual.size());
		
		Iterator<OWLIndividual> idindividual = individual.iterator();
		OWLObjectRenderer renderer = new DLSyntaxObjectRenderer();
		
		while (idindividual.hasNext()){
			OWLIndividual ind = idindividual.next();
			System.out.println(renderer.render(ind));
			
		}
		
		
		//cria um novo individuo
		
		OWLNamedIndividual newColor = factory.getOWLNamedIndividual(":"+colorName, pm);
		OWLClassAssertionAxiom classAssertion = factory.getOWLClassAssertionAxiom(cls, newColor);
		manager.addAxiom(Ontology, classAssertion);
		manager.saveOntology(Ontology);
		System.out.println(colorName+" inserido em "+classOWL);
		
		OWLObjectProperty nameColorProperty = factory.getOWLObjectProperty(":"+colorProperty, pm);
		//Collection<OWLIndividual> obPrp = EntitySearcher.getObjectPropertyValues(newInd, oPr, Ontology);		
		//Iterator<OWLIndividual> idObPrp = obPrp.iterator();
		
		
		
		//Insere propriedade ao individuo
		OWLNamedIndividual original = factory.getOWLNamedIndividual(":"+originalColor, pm);
		OWLObjectPropertyAssertionAxiom propertyAssertion = factory.getOWLObjectPropertyAssertionAxiom(nameColorProperty, newColor, original);
		System.out.println(original+" " + nameColorProperty +" " + newColor);
		
		manager.addAxiom(Ontology, propertyAssertion);
		manager.saveOntology(Ontology);
		
			
		//Insere data property
		OWLDataProperty code = factory.getOWLDataProperty(":"+propertyColor, pm);
		 OWLDataPropertyAssertionAxiom dataPropertyAssertion = factory.getOWLDataPropertyAssertionAxiom(code, newColor,
				 "#"+colorCode);
		 System.out.println(code+" " + newColor +" " + colorCode);
		 
		manager.addAxiom(Ontology, dataPropertyAssertion);
		manager.saveOntology(Ontology);
		
		
		
		OWLNamedIndividual userName = factory.getOWLNamedIndividual(":"+individualOWL, pm);
		
		//Insere propriedade ao individuo
		OWLNamedIndividual contextName = factory.getOWLNamedIndividual(":"+context, pm);
		OWLObjectProperty nameContextProperty = factory.getOWLObjectProperty(":"+contextProperty, pm);
		OWLObjectPropertyAssertionAxiom propertyAssertionContext = factory.getOWLObjectPropertyAssertionAxiom(nameContextProperty,userName, contextName);
		System.out.println(userName+" " + nameContextProperty +" " + contextName);
				
		manager.addAxiom(Ontology, propertyAssertionContext);
		manager.saveOntology(Ontology);
		
		//Insere propriedade ao individuo
		//OWLNamedIndividual contextName = factory.getOWLNamedIndividual(":"+context, pm);
		OWLObjectProperty namePreferenceProperty = factory.getOWLObjectProperty(":"+preferenceProperty, pm);
		OWLObjectPropertyAssertionAxiom propertyAssertionPreference = factory.getOWLObjectPropertyAssertionAxiom(namePreferenceProperty,userName, newColor);
		System.out.println(userName+" " + nameContextProperty +" " + contextName);
						
		manager.addAxiom(Ontology, propertyAssertionPreference);
		manager.saveOntology(Ontology);
		
		
		
		
		
	}

	
	
	
	
	
	
	

}

