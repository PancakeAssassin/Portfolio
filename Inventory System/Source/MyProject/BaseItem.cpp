

#include "MyProject.h"
#include "EngineGlobals.h"
#include "BaseItem.h"


ABaseItem::ABaseItem(const class FPostConstructInitializeProperties& PCIP)
	: Super(PCIP)
{
	MeshResource= PCIP.CreateDefaultSubobject<UStaticMeshComponent>(this, TEXT("ItemMesh"));
	SetRootComponent(MeshResource);

	Name= FString("Default Item");
	Description= FString("Text goes here");
	Value= 0;
	CurrentStackSize= 1;
	Type= ItemType::I_Trash;
}

FString ABaseItem::DisplayInfo()
{
	return FString("This needs to be changed");
}

int32 ABaseItem::GetValue()
{
	return Value;
}

void ABaseItem::BeginPlay()
{
	bStackable= true;
	MaxStackSize= 10;
}

FString ABaseItem::GetName()
{
	return Name;
}

bool ABaseItem::LoadItemFromRow(FName rowName)
{
	//load item from table
	FItemLookupTable* item= UTestSingleton::Get().ItemTable->FindRow<FItemLookupTable>(rowName, FString("LookUp Operation"));

	//if the item exists load it from the table
	if(item)
	{
		Name= item->ItemName;
		Value= item->Value;
		Description= item->Description;
		
		//load the mesh
		UStaticMesh* mesh= item->MeshResource.Get();
		//if the mesh is already in memory load it
		//if the mesh isn't loaded, grab a sting reference to its location and asynchronously load the mesh
		//and attach it to the item object
		if(mesh)
		{
			MeshResource->SetStaticMesh(mesh);
		}	
		else
		{
			FStreamableManager& Streamable= UTestSingleton::Get().AssetLoader;
			TArray<FStringAssetReference> ObjToLoad;
			ItemToLoad=item->MeshResource.ToStringReference();
			ObjToLoad.AddUnique(ItemToLoad);
			Streamable.RequestAsyncLoad(ObjToLoad, FStreamableDelegate::CreateUObject(this, &ABaseItem::DoAsyncItemLoad));
		}

		//if the material is already loaded add it to the object
		//if the material isnt already loaded grab a string reference to it and asynchronously load the 
		//material and attach it to the mesh
		UMaterial* mat= item->TextureResource.Get();
		if(mat)
		{
			MeshResource->SetMaterial(0, mat);
		}
		else
		{
			FStreamableManager& Streamable= UTestSingleton::Get().AssetLoader;
			TArray<FStringAssetReference> ObjToLoad;
			MaterialToLoad=item->TextureResource.ToStringReference();
			ObjToLoad.AddUnique(MaterialToLoad);
			Streamable.RequestAsyncLoad(ObjToLoad, FStreamableDelegate::CreateUObject(this, &ABaseItem::DoAsyncMaterialLoad));
		}
	}
	else
	{
		return false;
	}
	return true;
}

void ABaseItem::DoAsyncItemLoad()
{
	check(ItemToLoad.ResolveObject() != nullptr)
	{
		UObject* NewItemMesh= ItemToLoad.ResolveObject();
		MeshResource->SetStaticMesh(Cast<UStaticMesh>(NewItemMesh));
	}
}

void ABaseItem::DoAsyncMaterialLoad()
{
	check(MaterialToLoad.ResolveObject() != nullptr)
	{
		UObject* NewMaterial= MaterialToLoad.ResolveObject();
		MeshResource->SetMaterial(0, Cast<UMaterial>(NewMaterial));
	}
}