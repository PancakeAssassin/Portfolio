#pragma once

#include "GameFramework/Actor.h"
#include "TestSingleton.h"
#include "BaseItem.generated.h"

/**
 * 
 */
UENUM(BlueprintType)
enum ItemType
{
	I_Armor= 0,
	I_Weapon= 1,
	I_Consumable= 2,
	I_Lore= 3,
	I_Trash= 4,
};

USTRUCT(BlueprintType)
struct FItemLookupTable : public FTableRowBase
{
	GENERATED_USTRUCT_BODY()

public:

	FItemLookupTable()
	: ItemName("Default Name"),
	  Description("Blah blah blah"),
	  Value(0)
	{}

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category="GameItem")
	FString ItemName;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	FString Description;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	int32 Value;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	TAssetPtr<UMaterial> TextureResource;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= "GameItem")
	TAssetPtr<UStaticMesh> MeshResource;
};

UCLASS()
class MYPROJECT_API ABaseItem : public AActor
{
	GENERATED_UCLASS_BODY()

	//UDataTable* ItemTable;

	//Name of the item
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Name)
	FString Name;

	//Description text for the item
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Description)
	FString Description;

	//mesh for the item
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category= Mesh)
	TSubobjectPtr<UStaticMeshComponent> MeshResource;

	//Enumerated type for Item
	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category= ItemEnum)
	TEnumAsByte<ItemType> Type;

	//can more than 1 item of this type/name be stacked in the same place
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Stack)
	bool bStackable;

	//the maximum amount that can be stacked
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Stack)
	int32 MaxStackSize;

	//the current amount
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Stack)
	int32 CurrentStackSize;

	//value per 1 unit (cost of total stack can be calculated by multiplying by amount)
	UPROPERTY(VisibleAnywhere, BlueprintReadWrite, Category= Value)
	int32 Value;

	//Dummy display info function to be updated
	//when more of system is built
	//currently returns a string that reminds to update
	UFUNCTION(BlueprintCallable, Category= "ItemInfo")
	FString DisplayInfo();

	//Returns the monetary value of the item
	UFUNCTION(BlueprintCallable, Category= "ItemInfo")
	int32 GetValue();

	UFUNCTION(BlueprintCallable, Category= "LoadItem")
	bool LoadItemFromRow(FName rowName);

	UFUNCTION()
	FString GetName();

	void DoAsyncItemLoad();
	void DoAsyncMaterialLoad();


	virtual void BeginPlay() override;


private:
	FStringAssetReference ItemToLoad;
	FStringAssetReference MaterialToLoad;
};
